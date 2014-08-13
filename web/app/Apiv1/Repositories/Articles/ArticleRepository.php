<?php namespace Apiv1\Repositories\Articles;

use Apiv1\Repositories\Articles\ArticleLocation;
use Apiv1\Repositories\Articles\ArticleType;
use Apiv1\Repositories\Articles\Article;
use Apiv1\Repositories\Search\Search;
use Apiv1\Repositories\Models\BaseModel;
use Carbon\Carbon;
use Config;

Class ArticleRepository extends BaseModel {

    public function getArticlesByCategory($categoryId, $channelId)
    {
        $result = Article::select('article.*')
        ->join('article_location', 'article_location.article_id', '=', 'article.id')
        ->where('article_location.sub_channel_id', $channelId)
        ->where('article_location.category_id', $categoryId)
        ->with(['location' => function($query) use($channelId, $categoryId) {
                $query->where('article_location.sub_channel_id', $channelId)->where('article_location.category_id', $categoryId);
         }])
        ->with('event.venue', 'asset')
        ->get();

        return $result->toArray();
    }

    public function getArticleMapObjects($categoryId, $channelId, $lat, $lon, $distance)
    {
        //https://developers.google.com/maps/articles/phpsqlsearch_v3
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

        $query = Article::select('article.*', 'article_id AS id')->with('location', 'asset', 'gallery', 'event.venue', 'event.showTime' ,'venue', 'video', 'author');
        $query->join('article_location', 'article_location.article_id', '=', 'article.id');

        # If the identifier passed through is an integer then grab the row by the ID
        if( is_numeric($article) ) {
            $query->where('article.id', '=', $article);
        }
        # if its a string then try and fine it by the sef_name field
        else {
            $query->where('article.sef_name', '=', $article);
        }

        # if its a promotional channel then we also want to get the promotion data
        if( isPromotionType($channel) )
        {
            $query->with('promotion', 'competition.questions.answers');
        }

        $query->where('article_location.sub_channel_id', getSubChannelId($channel));
        $query->where('article_location.category_id', $category['id']);

        if( ! $result = $query->first() )
        {
            return false;
        }
        else
        {
            return $result;    
        }   
    }

    public function getArticle($identifier)
    {
        $query = Article::with('location', 'asset', 'event.venue', 'venue');

        if( is_numeric($identifier) ) {
            $query->where('article.id', '=', $identifier);
        }
        else {
            $query->where('article.sef_name', '=', $identifier);
        }

        if( ! $result = $query->first() ) {
            return false;
        }
        else {
            return $result->toArray();    
        }        
    }

    /**
     * For a channel of type listing get articles based on the ranges passed
     * 
     * @param  [type]  $channel   [description]
     * @param  integer $limit     [description]
     * @param  [type]  $range     [description]
     * @param  [type]  $timestamp [description]
     * @return [type]             [description]
     * 
     */
    public function getChannelListing( $channel, $limit = 1000, $range, $timestamp )
    {
        $dateStamp = convertTimestamp( 'Y-m-d', $timestamp);

        $query = ArticleLocation::with('article.event.venue', 'article.event.showTime', 'article.asset', 'article.location')->select(
            'article.title', 'article_location.article_id'
        )
        ->join('article', 'article.id', '=', 'article_location.article_id')
        ->join('event_showtimes', 'event_showtimes.event_id', '=', 'article.event_id')
        ->where('sub_channel_id', $channel);

        if( $range == "week" )
        { 

            $dateArray = explode('-', $dateStamp);  
            $query->where('event_showtimes.showtime', '>=', $dateStamp.' 00:00:01');
            $query->where('event_showtimes.showtime', '<=', Carbon::create($dateArray[0], $dateArray[1], $dateArray[2], '23', '59', '59')->addDays(6));

            $query->where('article.is_picked', '=', true);
        }
        elseif ( $range == "day" )
        {
            $query->where('event_showtimes.showtime', '>=', $dateStamp.' 00:00:01');
            $query->where('event_showtimes.showtime', '<=', $dateStamp.' 23:59:59');
        }

        $result = $query->orderBy('event_showtimes.showtime', 'asc')->get();

        $articles = [];
        $articleIds = [];

        // they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
        foreach( $result->toArray() AS $item )
        {
            $articleId = $item['article']['id'];
            
            if( ! in_array($articleId, $articleIds)) {
                $articles[] = $item['article'];    
            }
            
            $articleIds[] = $articleId;
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
        ->where('article.title', 'LIKE', "%{$searchTerm}%");

        $result = $query->orderBy('article.title', 'asc')->get();

        $articles = [];
        
        // they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
        foreach( $result->toArray() AS $item )
        {
            $articles[] = $item['article'];
        }
        
        Search::record($searchTerm, count($articles));

        return $articles;
    }

    /**
     * Get a list of articles for a range of criteria
     * 
     * @param  string  $type          [what type of article do we want to return ]
     * @param  integer $limit         [total article results to return]
     * @param  [type]  $channel       [unique identifier for the channel or sub-channel]
     * @param  boolean $isASubChannel [whether the $channel ID is for a subChannel]
     * @param  boolean $ignoreChannel [sometimes we dont care what type of channel to return so ignore it]
     * @return mixed                 [an array of articles or boolean false on nothing]
     * 
     */
    public function getArticles($type = 'article', $limit = 20, $channel = null, $isASubChannel = false, $ignoreChannel = false)
    {
        $query = ArticleLocation::with('article.event.venue', 'article.venue', 'article.event.showTime', 'article.asset', 'article.location')->select(
            'article.title', 'article_location.article_id'
        )->join('article', 'article.id', '=', 'article_location.article_id');

        # on the homepage we don't care which channel the featured or picked articles come from
        if( !$ignoreChannel ) 
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
           
        switch($type)
        {
            case 'picks' :
                $query->where('article.is_picked', '=', true)->where('article.is_featured', '=', false);
            break;
            case Config::get('constants.displayType_directory') :
            case 'featured' :
                $query->where('article.is_featured', '=', true);
            break;
        }

        $result = $query->orderBy('article.created_at', 'desc')->take($limit)->get();

        $articles = [];
        
        # they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
        foreach( $result->toArray() AS $item )
        {
            $articles[] = $item['article'];
        }

        return $articles;
    }

    public function getArticlesWhereNotInCollection( $articles = [], $type = 1, $limit = 100 )
    {
        return Article::with('location', 'asset', 'event.venue')->whereNotIn( 'id', $articles )->orderBy('article.created_at', 'desc')->take($limit)->get();        
    }

    public function getArticlesWithEvents($type, $channel)
    {
        $limit = Config::get('constants.channelFeed_limit');

        $query = Article::with('asset')->with(['location' => function($query) use($channel) {
                $query->where('article_location.channel_id', $channel);
        }])->with(['event' => function($query) {
                $query->orderBy('event.show_date', 'asc')->alive()->active();
        }])->with('event.venue', 'event.showTime');

        return $query->whereNotNull('article.event_id')->take($limit)->get()->toArray();
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

    public function getRelatedArticles($article)
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

        return $articles;
    }
}