<?php namespace Apiv1\Repositories\Articles;

use Apiv1\Repositories\Articles\ArticleLocation;
use Apiv1\Repositories\Articles\ArticleType;
use Apiv1\Repositories\Articles\Article;
use Apiv1\Repositories\Events\Event;
use Apiv1\Repositories\Events\ShowTime;
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
     * An example endpoint request, which reaches this method: category/5/article/articles?subChannel=11
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
        ->where('article.is_approved', true)
        ->orderBy('article.published', 'desc')
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
    
        $query = DB::select(DB::raw("
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
        )->with('article.location')
        ->where('sub_channel_id', $channelId)
        ->where('category_id', $categoryId)
        ->whereIn('article.id', $ids)
        ->join('article', 'article.id', '=', 'article_id')
        ->where('article.is_approved', true)
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
        $query = Article::select('article.*', 'article_location.article_id AS id')
        ->with('location', 'asset', 'gallery', 'event.venue', 'event.showTime', 'event.showTime.venue', 'event.cinema', 'venue', 'video', 'author')
        ->join('article_location', 'article_location.article_id', '=', 'article.id');

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
        $query->where('article.is_approved', true);

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

        $query = ArticleLocation::with('article.event.venue'
            , 'article.venue'
            , 'article.event.showTime'
            , 'article.event.showTime.venue'
            , 'article.event.cinema'
            , 'article.asset'
            , 'article.location')->select(
            'article.title', 'article_location.article_id'
        )->join('article', 'article.id', '=', 'article_location.article_id');

        # Listings don't have to be unique as they might be playing on multiple days so we want to see them all. 
        # everything else though should be unique. This ensure unique articles are returned.
        if($type != 'listing')
        {
            $query->distinct('article.id');
        }

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
                $query->whereNotIn('channel_id', $user->inactive_channels);    
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
        $query->where('article.is_approved', true)->take($limit);

        # and by default order all articles by their publication date
        $query->orderBy('article.published', 'desc');

        # and...... go 
        $result = $query->get();        

        $articles = [];            
        $ids = [];

        # they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
        foreach( $result->toArray() AS $item )
        {
            $article = $item['article'];

            if(!in_array($article['id'], $ids))
            {
                $articles[] = $item['article'];    

                $ids[] = $article['id'];
            }            
        }

        # ... finally, we want to apply a filter to promote some of these articles based on the user' district
        # preferences. 
        if( ! is_null($user))
        {
            $articles = App::make('Apiv1\Tools\UserDistrictOrganiser')->promoteDistricts($user, $articles);    
        }
        
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
        # convert the passed in time stamp to a format we can use in the DB call
        $dateStamp = convertTimestamp( 'Y-m-d', $timestamp);

        $query = DB::table('event_showtimes AS es')->select(
                'es.id AS showTime_Id',
                'es.event_id AS showTime_EventId',
                'es.showtime AS showTime_showTime',
                'es.showend AS showTime_showEnd',
                'es.price AS showTime_price',
                'es.venue_id AS showTime_venueId',
                'ec.id AS eventCinema_id',
                'ec.event_id AS eventCinema_eventId',
                'ec.director AS eventCinema_director',
                'ec.duration AS eventCinema_duration',
                'v.id AS venue_id',
                'v.name AS venue_name',
                'v.sef_name AS venue_sefName',
                'v.address_line_1 AS venue_addressLine1',
                'v.address_line_2 AS venue_addressLine2',
                'v.address_line_3 AS venue_addressLine3',
                'v.postcode AS venue_postcode',
                'v.email AS venue_email',
                'v.lat AS venue_lat',
                'v.lon AS venue_lon',
                'v.area AS venue_area',
                'v.facebook AS venue_facebook',
                'v.twitter AS venue_twitter',
                'v.phone AS venue_phone',
                'v.created_at AS venue_createdAt',
                'v.updated_at AS venue_updatedAt',
                'v.is_active AS venue_isActive',
                'v.is_deleted AS venue_isDeleted',
                'v.is_directory AS venue_isDirectory',
                'v.website AS venue_website'
            )
        ->leftJoin('event_cinema AS ec', 'ec.event_id', '=', 'es.event_id')
        ->join('venue AS v', 'v.id', '=', 'es.venue_id');

        if( $range == "week" )
        { 
            $dateArray = explode('-', $dateStamp);  

            # if the show time (start) is greater than or equal to the provided period in time
            $query->where('es.showtime', '>=', $dateStamp.' 00:00:01');

            # and the end the show time (start) is less than or equal to the provided period in time plus 6 days
            $query->where('es.showtime', '<=', Carbon::create($dateArray[0], $dateArray[1], $dateArray[2], '23', '59', '59')->addDays(6));
        }
        # or just grab a days worth
        elseif ( $range == "day" )
        {            
            $query->where('es.showtime', '>=', $dateStamp.' 00:00:01');            
            $query->where('es.showtime', '<=', $dateStamp.' 23:59:59');
        }

        $showTimes = $query->get();

        $shows = [];
        $eventIds = [];

        foreach($showTimes AS $show)
        {
            if(!in_array($show->showTime_EventId, $eventIds))
            {
                $eventIds[] = $show->showTime_EventId;
            }

            $shows[$show->showTime_EventId][] = $show;
        }

        $query = Article::select('article.*', 'al.sub_channel_id')->with('location', 'asset', 'event.cinema')
        ->join('article_location AS al', 'al.article_id', '=', 'article.id')        
        ->where('article.is_approved', true)
        ->whereIn('article.event_id', $eventIds)
        ->limit($limit)
        ->active();

        # if its not the top level Whats On channel then we need to refine by the sub-channel being requested
        if($channel != Config::get('global.whatsOnChannelId'))
        {
            $query->where('al.sub_channel_id', $channel); 
        }
        else {
            $query->distinct('article.id');
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
  
        $articles = $query->orderBy('article.created_at', 'desc')->get()->toArray();
   
        foreach($articles AS $key => $article)
        {
            if(!isset($articles[$key]['location'][0]))
            {
                unset($articles[$key]);
            }
            else
            {
                if(array_key_exists($article['event_id'], $shows))
                {
                    $articles[$key]['showTimes'] = $shows[$article['event_id']];
                }

                $eventShowTimes = [];

                foreach($articles[$key]['showTimes'] AS $showTime)
                {
                    $eventShowTimes[] = [
                        'id' => $showTime->showTime_Id,
                        'event_id' => $showTime->showTime_EventId,
                        'showtime' => $showTime->showTime_showTime,
                        'showend' => $showTime->showTime_showEnd,
                        'price' => $showTime->showTime_price,
                        'venue_id' => $showTime->showTime_venueId,
                        'venue' => [
                            'id' => $showTime->venue_id,
                            'name' => $showTime->venue_name,
                            'sef_name' => $showTime->venue_sefName,
                            'address_line_1' => $showTime->venue_addressLine1,
                            'address_line_2' => $showTime->venue_addressLine2,
                            'address_line_3' => $showTime->venue_addressLine3,
                            'postcode' => $showTime->venue_postcode,
                            'email' => $showTime->venue_email,
                            'lat' => $showTime->venue_lat,
                            'lon' => $showTime->venue_lon,
                            'area' => $showTime->venue_area,
                            'facebook' => $showTime->venue_facebook,
                            'twitter' => $showTime->venue_twitter,
                            'phone' => $showTime->venue_phone,
                            'created_at' => $showTime->venue_createdAt,
                            'updated_at' => $showTime->venue_updatedAt,
                            'is_active' => $showTime->venue_isActive,
                            'is_deleted' => $showTime->venue_isDeleted,
                            'is_directory' => $showTime->venue_isDirectory,
                            'website' => $showTime->venue_website,
                        ]
                    ];                
                }

                unset($articles[$key]['showTimes']);

                $articles[$key]['event']['show_time'] = $eventShowTimes;
            }          
        }

        # ... finally, we want to apply a filter to promote some of these articles based on the user' district
        # preferences. 
        $articles = App::make('Apiv1\Tools\UserDistrictOrganiser')->promoteDistricts($user, $articles);

        return $articles;
    }

    /**
     * retrieve a list of articles from a provided array of identifiers
     * 
     * @param  array $ids   [list of unique identifiers for articles to return]
     * @return array        [a list of articles]
     */
    public static function getArticlesByIds(array $ids)
    {
        $articles = [];

        # if we have some id's to work with
        if(is_array($ids) & count($ids) > 0)
        {   
            $query = ArticleLocation::with('article.event.venue', 'article.event.showTime', 'article.asset', 'article.location')->select(
                'article.title', 'article_location.article_id'
            )
            ->join('article', 'article.id', '=', 'article_location.article_id')
            ->whereIn('article.id', $ids)
            ->orderBy('article.title', 'asc')
            ->where('article.is_approved', true);

            $result = $query->get();

            # they come out of this query slightly differently to how the articleTransformer needs them. 
            # sort that out !
            foreach( $result->toArray() AS $item ) {
                $articles[] = $item['article'];
            }
        }
 
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
        ->join('channel AS c1', 'c1.id', '=', 'article_location.channel_id')
        ->join('channel AS c2', 'c2.id', '=', 'article_location.sub_channel_id')
        ->join('category', 'category.id', '=', 'article_location.category_id')
        ->where('article.title', 'LIKE', "%{$searchTerm}%")
        ->where('article.is_approved', true) // articles have to be approved to appear on the site
        ->where('c1.is_active', true) // top level channels have to be active for the article to appear on the site
        ->where('c2.is_active', true) // sub-channels have to be active for the article to appear on the site
        ->where('category.is_active', true); // categories have to be active for the article to appear on the site

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
        ->join('article', 'article.id', '=', 'article_location.article_id')
        ->where('article.is_approved', true)
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
                ->where('article.is_approved', true)
                ->orderBy('article.published', 'asc')
                ->get()->toArray();

        $counter = 0;
        $articles = [];

        foreach( $result AS $item )
        {        
            # store the first item in the list in case we need to use it
            if($counter == 0)
            {
                $first = $item;
            }

            # if we find the article then we want to try and get the previous item, and the one after
            # it.
            if( $item['article_id'] == $article->id)
            {
                $articles['previous'] = isset($result[$counter-1]) ? $result[$counter-1]['article'] : null;
                $articles['article'] = $article->toArray();
                $articles['next'] = isset($result[$counter+1]) ? $result[$counter+1]['article'] : null;
            }

            $counter++;
        }

        # if there isn't a previous article, likely because its the first in the list then set the previous article
        # to be the last in the list
        if(is_null($articles['previous'])) {
             $articles['previous'] = $result[count($result)-1]['article'];
        }
    
        # if there isn't a next article, likely because this is the last item in the list, then set the next article
        # to be the first item in the result set
        if(is_null($articles['next'])) {
            $articles['next'] = $first['article'];
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
                ->where('article.is_approved', true)
                ->get()->take(6)->toArray();

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