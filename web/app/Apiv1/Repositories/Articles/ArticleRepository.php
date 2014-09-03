<?php namespace Apiv1\Repositories\Articles;

use Apiv1\Repositories\Articles\ArticleLocation;
use Apiv1\Repositories\Articles\ArticleType;
use Apiv1\Repositories\Articles\Article;
use Apiv1\Repositories\Search\Search;
use Apiv1\Repositories\Models\BaseModel;
use Carbon\Carbon;
use Config;
use App;
use DB;

Class ArticleRepository extends BaseModel {

    public $articleData = ['event.venue', 'asset', 'event.showTime', 'event.showTime.venue', 'event.cinema', 'venue'];

    /**
     * locate and return an article by its unique identifier
     * 
     * @param  int || string $identifier [either the ID or sef_name attribute from the article table]
     * @return array
     */
    public function getArticleByIdentifier($identifier = null)
    {
        # if we have something to try and find the article by
        if( ! is_null($identifier) )
        {
            $query = Article::active();

            # if the identifier is numeric then its likely the article ID thats been supplied
            if(is_numeric($identifier)) {
                $query->whereId($identifier);
            }
            # otherwise try and use the sef_name field to find it
            else {
                $query->whereSefName($identifier);
            }

            # execute
            $result = $query->first();

            # ... and return
            return $result;
        }
        else {
            return false;
        }
    }

    /** 
     * retrieve a list of articles assigned to a particular sub-channel/category
     * 
     * @param  int $categoryId
     * @param  int $channelId
     * @return array
     */
    public function getArticlesByCategory($categoryId, $channelId)
    {
        $result = Article::select('article.*')
        ->join('article_location', 'article_location.article_id', '=', 'article.id')
        ->where('article_location.sub_channel_id', $channelId)
        ->where('article_location.category_id', $categoryId)
        ->with(['location' => function($query) use($channelId, $categoryId) {
                $query->where('article_location.sub_channel_id', $channelId)->where('article_location.category_id', $categoryId);
         }])
        ->with($this->articleData)
        ->get();

        return $result->toArray();
    }

    /**
     * grab the map objects that are specified distance from provided lat/lon entries
     * 
     * @param  int $categoryId
     * @param  int $channelId
     * @param  float $lat
     * @param  float $lon
     * @param  int $distance
     * @return array
     */
    public function getArticleMapObjects($categoryId, $channelId, $lat, $lon, $distance)
    {
        # https://developers.google.com/maps/articles/phpsqlsearch_v3
    
        $query = \DB::select(\DB::raw("
            SELECT article.id, 
            ( 6371 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lon ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance 
            FROM article 
            JOIN article_location ON article_location.article_id = article.id
            WHERE article_location.sub_channel_id = $channelId
            AND article_location.category_id = $categoryId
            HAVING distance < 25 ORDER BY distance LIMIT 0 , 100
        "));

        $ids = [];

        foreach( $query AS $q )
        {
            if( $q->distance < $distance )
            {
                $ids[] = $q->id;
            }
        }

        $result = ArticleLocation::select(
            'article_id', 'article.title', 'article.lat', 'article.lon'
        )->where('sub_channel_id', $channelId)
        ->where('category_id', $categoryId)
        ->whereIn('article.id', $ids)
        ->join('article', 'article.id', '=', 'article_id')
        ->active()
        ->get();

        return $result;
    }

    /**
     * When we get down to the category level the article content is more verbose. Grab all of the data
     * we need to populate the templates!
     * 
     * @param  array $channel  [transformed channel array containing all sub-channels and categories]
     * @param  array $category [transformed category array]
     * @param  mixed $article  [unique identifer for the article. Can be a string or an integer]
     * @return mixed           [boolean on failure, Apiv1\Repositories\Articles\Article on success]
     */
    public function getCategoryArticle($channel, $category, $article)
    {       
        $query = Article::select('article.*', 'article_location.article_id AS id')->with('location', 'asset', 'gallery', 'event.venue', 'event.showTime', 'event.showTime.venue', 'event.cinema', 'venue', 'video', 'author');
        $query->join('article_location', 'article_location.article_id', '=', 'article.id');

        # if its a promotional channel then we also want to get the promotion data
        if( isPromotionType($channel) ) {
            $query->with('promotion', 'competition.questions.answers');    
        }

        # If the identifier passed through is an integer then grab the row by the ID
        if( is_numeric($article) ) {
            $query->where('article.id', '=', $article);
        }
        # if its a string then try and find it by the sef_name field
        else {
            $query->where('article.sef_name', '=', $article);
        }

        $query->where('article_location.sub_channel_id', getSubChannelId($channel));
        $query->where('article_location.category_id', $category['id']);

        if( ! $result = $query->first() ) {
            return false;
        }
        else {
            return $result;    
        }   
    }
    
    /**
     * Get a list of articles for a range of criteria
     * 
     * @param  string  $type          [what type of article do we want to return ]
     * @param  integer $limit         [total article results to return]
     * @param  [type]  $channel       [unique identifier for the channel or sub-channel]
     * @param  boolean $isASubChannel [whether the $channel ID is for a subChannel]
     * @param  boolean $ignoreChannel [sometimes we don't care what type of channel to return so ignore it]
     * @return mixed                 [an array of articles or boolean false on nothing]
     * 
     */
    public function getArticles($type = 'article', $limit = 20, $channel = null, $isASubChannel = false, $ignoreChannel = false, $user = null)
    {
        # flag to indicate whether a sort order has been given to the query 
        # (this can be done in a couple of places, hence the flag)
        $sorted = false;

        $query = ArticleLocation::with('article.event.venue', 'article.venue', 'article.event.showTime', 'article.event.showTime.venue', 'article.event.cinema', 'article.asset', 'article.location')->select(
            'article.title', 'article_location.article_id'
        )->join('article', 'article.id', '=', 'article_location.article_id');

        # on the homepage we don't care which channel the featured or picked articles come from
        if( ! $ignoreChannel ) 
        {
            # if its a sub-channel then grab it by the sub-channel ID
            if ( $isASubChannel ) {
                $query->where('sub_channel_id', $channel);
            }
            # otherwise use the channel_id field
            else { 
                $query->where('channel_id', $channel);
            }           
        }   

        # if we have a user object we only want to grab content that they want to see
        if( ! is_null($user))    
        {
            # don't get any articles from channels they have disabled
            if( count($user->inactive_channels) > 0 ) {
                $query->whereNotIn('channel_id', $user->inactive_channels, 'or');    
                $query->whereNotIn('sub_channel_id', $user->inactive_channels);    
            }

            # don't get any articles from categories they have disabled. Note that categories can be used in multiple
            # channels so the sub_channel_id is needed to distinguish one from the other
            if( count($user->inactive_categories) > 0 ) 
            {
                $cats = [];
                $chans = [];

                # go through the user disabled list and grab separate lists of categories and channels
                foreach($user->inactive_categories AS $key => $cat)
                {
                    $cats[] = $key;
                    $chans[] = $cat['subchannel'];
                }

                # grab a list of row ids from article_location which include both a category_id and a sub_channel_id that have been disabled by the user
                $excludeIds = DB::table('article_location')->select('id')->whereIn('category_id', $cats)->whereIn('sub_channel_id', $chans)->lists('id');

                # now grab everything else not in the $excludedIds list. This is the content the user wants to see.
                if(is_array($excludeIds) && count($excludeIds) > 0) {
                    $query->whereNotIn('article_location.id', $excludeIds);    
                }           
            }    
        }
       
        switch($type)
        {
            # if we only want picked articles
            case 'picks' :
                $query->where('article.is_picked', '=', true)->where('article.is_featured', '=', false);
            break;
            # if its a listing we want to filter by the event attached to the article
            case 'listing' :                
                $query->join('event_showtimes', 'event_showtimes.event_id', '=', 'article.event_id')->distinct('event_showtimes.event_id')->orderBy('event_showtimes.showtime', 'asc');
                $sorted = true;
            # if its a directory type article or we want featured articles
            case Config::get('constants.displayType_directory') :
            case 'featured' :
                $query->where('article.is_featured', '=', true);
            break;
        }

        # by default ensure we only get approved articles
        $query->whereNotNull('article.is_approved')->take($limit);

        # and by default order all articles by their publication date
        $query->orderBy('article.published', 'desc');

        # and...... go 
        $result = $query->get();        

        $articles = [];
        
        # they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
        foreach( $result->toArray() AS $item )
        {
            $articles[] = $item['article'];
        }

        # ... finally, we want to apply a filter to promote some of these articles based on the user' district
        # preferences. 
        $articles = App::make('Apiv1\Tools\UserDistrictOrganiser')->promoteDistricts($user, $articles);
  
        return $articles;
    }

    /**
     * For a channel of type listing get articles based on the ranges passed
     * 
     * @param  array $channel
     * @param  integer $limit     the number of results to return
     * @param  string  $range     the range of articles. Either a 'week' or a 'day'. Determines the type of result set
     * @param  int $timestamp     the period in time we want to grab articles for
     * 
     * @return array $result
     */
    public function getChannelListing( $channel, $limit = 1000, $range, $timestamp, $user = null )
    {
        $dateStamp = convertTimestamp( 'Y-m-d', $timestamp);

        $query = ArticleLocation::with('article.event.cinema', 'article.event.showTime.venue', 'article.asset', 'article.location')->select(
            'article.title', 'article_location.article_id'
        )
        ->join('article', 'article.id', '=', 'article_location.article_id')
        ->join('event_showtimes', 'event_showtimes.event_id', '=', 'article.event_id')
        ->where('sub_channel_id', $channel);

        // grab a weeks worth of articles from a specified point in time
        if( $range == "week" )
        { 
            $dateArray = explode('-', $dateStamp);  

            # if the show time (start) is greater than or equal to the provided period in time
            $query->where('event_showtimes.showtime', '>=', $dateStamp.' 00:00:01');

            # and the end the show time (start) is less than or equal to the provided period in time plus 6 days
            $query->where('event_showtimes.showtime', '<=', Carbon::create($dateArray[0], $dateArray[1], $dateArray[2], '23', '59', '59')->addDays(6));
        }
        # or just grab a days worth
        elseif ( $range == "day" )
        {            
            $query->where('event_showtimes.showtime', '>=', $dateStamp.' 00:00:01');            
            $query->where('event_showtimes.showtime', '<=', $dateStamp.' 23:59:59');
        }

        # if we have a user object we only want to grab content that they want to see
        if( ! is_null($user))    
        {
            # don't get any articles from channels they have disabled
            if( count($user->inactive_channels) > 0 ) {
                $query->whereNotIn('channel_id', $user->inactive_channels, 'or'); 
                $query->whereNotIn('sub_channel_id', $user->inactive_channels);    
            }

            # don't get any articles from categories they have disabled. Note that categories can be used in multiple
            # channels so the sub_channel_id is needed to distinguish one from the other
            if( count($user->inactive_categories) > 0 ) 
            {
                $cats = [];
                $chans = [];

                # go through the user disabled list and grab separate lists of categories and channels
                foreach($user->inactive_categories AS $key => $cat)
                {
                    $cats[] = $key;
                    $chans[] = $cat['subchannel'];
                }

                # grab a list of row ids from article_location which include both a category_id and a sub_channel_id that have been disabled by the user
                $excludeIds = DB::table('article_location')->select('id')->whereIn('category_id', $cats)->whereIn('sub_channel_id', $chans)->lists('id');

                # now grab everything else not in the $excludedIds list. This is the content th user wants to see.
                $query->whereNotIn('article_location.id', $excludeIds);
            }            
        }

        # order them by the earliest show time and pull them out of the DB
        $result = $query->orderBy('event_showtimes.showtime', 'asc')->active()->get();

        $articles = [];        
        $articleIds = [];

        # they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
        if($result->count() > 0)
        {
            foreach($result AS $item )
            {
                $articleId = $item->article_id;
                
                if( ! in_array($articleId, $articleIds)) {
                    $articles[] = $item->article->toArray();    
                }
                
                $articleIds[] = $articleId;
            }    
        }      

        # ... finally, we want to apply a filter to promote some of these articles based on the user' district
        # preferences. 
        $articles = App::make('Apiv1\Tools\UserDistrictOrganiser')->promoteDistricts($user, $articles);

        return $articles;
    }

    /**
     * Carry out a simple search of all articles by a specified term
     * 
     * @param  string $searchTerm [the string to search for]
     * @return array [a list of articles matching the specified search term]
     */
    public function search($searchTerm)
    {
        $query = ArticleLocation::with('article.event.venue', 'article.event.showTime', 'article.asset', 'article.location')->select(
            'article.title', 'article_location.article_id'
        )
        ->join('article', 'article.id', '=', 'article_location.article_id')
        ->where('article.title', 'LIKE', "%{$searchTerm}%");

        $result = $query->orderBy('article.title', 'asc')->get();

        $articles = [];
        
        // they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
        foreach( $result->toArray() AS $item ) {
            $articles[] = $item['article'];
        }
        
        Search::record($searchTerm, count($articles));

        return $articles;
    }

    public function countArticlesInCategory($categoryId, $channelId)
    {
        return ArticleLocation::where('category_id', $categoryId)->where('sub_channel_id', $channelId)->count();
    }

    public function getChannelArticleCategory($channelId)
    {
        return ArticleLocation::select(
            'article_id',
            'cat.name AS categoryName',
            'cat.sef_name AS categorySefName',
            'cat.id AS categoryId',
            'c.name as channelName',
            'c.sef_name as channelSefName',
            'sc.name as subChannelName',
            'sc.sef_name as subChannelSefName'
        )
        ->where('sub_channel_id', $channelId)
        ->join('category AS cat', 'article_location.category_id', '=', 'cat.id')
        ->join('channel AS c', 'c.id', '=', 'article_location.channel_id')
        ->join('channel AS sc', 'sc.id', '=', 'article_location.sub_channel_id')
        ->get()
        ->toArray();
    }

    public function getNextAndPreviousArticles($article)
    {
        $categoryId = $article->location->first()->categoryId;
        $subChannelId = $article->location->first()->subChannelId;

        $result = ArticleLocation::with('article.location')
                ->join('article', 'article.id', '=', 'article_location.article_id')
                ->where('article_location.category_id', '=', $categoryId)
                ->where('article_location.sub_channel_id', '=', $subChannelId)
                ->orderBy('article.published', 'asc')
                ->get()->toArray();

        $counter = 0;
        $articles = [];

        foreach( $result AS $item )
        {         
            if( $item['article_id'] == $article->id)
            {
                $articles['previous'] = isset($result[$counter-1]) ? $result[$counter-1]['article'] : null;
                $articles['article'] = $article->toArray();
                $articles['next'] = isset($result[$counter+1]) ? $result[$counter+1]['article'] : null;
            }

            $counter++;
        }

        return $articles;
    }

    public function getRelatedArticles($article, $user)
    {
        $articleLocation = $article->location->first();

        $result  = ArticleLocation::with('article.event.venue', 'article.event.showTime', 'article.asset', 'article.location')
                ->join('article', 'article.id', '=', 'article_location.article_id')
                ->where('article_location.sub_channel_id', '=', $articleLocation['subChannelId'])
                ->where('article_location.category_id', '=', $articleLocation['categoryId'])
                ->where('article.id', '!=', $article->id)
                ->orderBy('article.published', 'desc')
                ->get()->take(5)->toArray();

        $articles = [];

        foreach($result AS $item)
        {
            $articles[] = $item['article'];
        }

        # ... finally, we want to apply a filter to promote some of these articles based on the user' district
        # preferences. 
        $articles = App::make('Apiv1\Tools\UserDistrictOrganiser')->promoteDistricts($user, $articles);

        return $articles;
    }
}