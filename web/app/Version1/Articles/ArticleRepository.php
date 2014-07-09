<?php namespace Version1\Articles;

use Version1\Articles\ArticleInterface;
use Version1\Articles\ArticleLocation;
use Version1\Articles\ArticleType;
use Version1\Articles\Article;
use Version1\Models\BaseModel;
use \Carbon\Carbon;

Class ArticleRepository extends BaseModel implements ArticleInterface {

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

    public function getArticleMapObjects($categoryId, $channelId)
    {
        $result = ArticleLocation::select(
            'article_id', 'article.title', 'article.lat', 'article.lon'
        )->where('sub_channel_id', $channelId)
        ->where('category_id', $categoryId)
        ->join('article', 'article.id', '=', 'article_id')
        ->active()
        ->get();

        return $result;
    }

    public function getArticle($identifier)
    {
        $query = Article::with('location', 'asset', 'event.venue');

        if( is_numeric($identifier) )
        {
            $query->where('article.id', '=', $identifier);
        }
        else
        {
            $query->where('article.sef_name', '=', $identifier);
        }

        if( ! $result = $query->first() )
        {
            return false;
        }
        else
        {
            return $result->toArray();    
        }        
    }

    public function getChannelListing( $channel, $limit = 1000, $range, $timestamp )
    {
        $dateStamp = convertTimestamp( 'Y-m-d', $timestamp);

        $query = ArticleLocation::with('article.event.venue', 'article.asset', 'article.location')->select(
            'article.title', 'article_location.article_id'
        )
        ->join('article', 'article.id', '=', 'article_location.article_id')
        ->where('sub_channel_id', $channel);

        if( $range == "week" )
        { 
            $dateArray = explode('-', $dateStamp);  
            $query->where('article.published', '>=', $dateStamp.' 00:00:01');
            $query->where('article.published', '<=', Carbon::create($dateArray[0], $dateArray[1], $dateArray[2], '23', '59', '59')->addWeeks(1));

            $query->where('article.is_picked', '=', true);
        }
        elseif ( $range == "day" )
        {
            $query->where('article.published', '>=', $dateStamp.' 00:00:01');
            $query->where('article.published', '<=', $dateStamp.' 23:59:59');
        }

        $result = $query->orderBy('article.published', 'desc')->get();

        $articles = [];
        
        // they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
        foreach( $result->toArray() AS $item )
        {
            $articles[] = $item['article'];
        }

        return $articles;
    }

    public function getArticlesBySubChannel($limit = 20, $channel = null, $articleTransformer)
    {
        $articles = static::getArticles(null, 1000, $channel);

        $response = [];

        foreach( $articles AS $article )
        {
            if( ! $article['is_featured'] and ! $article['is_picked'] and empty($article['event_id']) )
            {
                $subChannel = $article['location'][0];

                $response[$subChannel['subChannelSefName']]['details'] = [
                    'id' => $subChannel['subChannelId']
                    ,'name' => $subChannel['subChannelName']
                ];

                if( !isset($response[$subChannel['subChannelSefName']]['articles']) )
                {
                    $response[$subChannel['subChannelSefName']]['articles'] = [];
                }

                if( count($response[$subChannel['subChannelSefName']]['articles']) < $limit)
                {
                    $response[$subChannel['subChannelSefName']]['articles'][] = $articleTransformer->transform($article, [ 'showBody' => false] );
                }
            }
        }

        return array_values($response); // reset the associative array key values to integer valeus and return
    }

    public function getArticles($type = 'article', $limit = 20, $channel = null, $isASubChannel = null, $fromCF = false)
    {
        $query = ArticleLocation::with('article.event.venue', 'article.asset', 'article.location')->select(
            'article.title', 'article_location.article_id'
        )
        ->join('article', 'article.id', '=', 'article_location.article_id');

        if ( $isASubChannel )
        {
            $query->where('sub_channel_id', $channel);
        }
        else        
        { 
            $query->where('channel_id', $channel);
        }        
            
        switch($type)
        {
            case 'picks' :
                $query->where('article.is_picked', '=', true)->where('article.is_featured', '=', false);
            break;
            case \Config::get('constants.displayType_directory') :
            case 'featured' :
                $query->where('article.is_featured', '=', true);
            break;
        }

        $result = $query->orderBy('article.created_at', 'desc')->take($limit)->get();

        $articles = [];
        
        // they come out of this query slightly differently to how the articleTransformer needs them. sort that out !
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

    public function getArticlesWithEvents($type, $channel = 50)
    {
        $query = Article::with('asset')->with(['location' => function($query) use($channel) {
                $query->where('article_location.channel_id', $channel);
        }])->with(['event' => function($query) {
                $query->orderBy('event.show_date', 'asc')->alive()->active();
        }])->with('event.venue');

        return $query->whereNotNull('article.event_id')->get()->toArray();
    }

    public function storeArticle($form)
    {
        if( !empty($form['id']) )
        {
            $article = Article::find($form['id']);
        }
        else
        {
            $article = new Article();
        }

        if( \Config::get('app.fakeIt') )
        {
            $faker = \Faker\Factory::create();

            $article->title = ! empty($form['title']) ? $form['title'] : $faker->catchPhrase();
            $article->sub_heading = ! empty($form['sub_heading']) ? $form['sub_heading'] : $faker->bs();
            $article->body = ! empty($form['body']) ? $form['body'] : $faker->text();
            $article->postcode = ! empty($form['postcode']) ? $form['postcode'] : $faker->postcode();
        }
        else
        {
            $article->title = ! empty($form['title']) ? $form['title'] : null;
            $article->sub_heading = ! empty($form['sub_heading']) ? $form['sub_heading'] : null;
            $article->body = ! empty($form['body']) ? $form['body'] : null;
            $article->postcode = ! empty($form['postcode']) ? $form['postcode'] : null;
        }

        $article->event_id = ! empty($form['event']) ? $form['event'] : null;
        $article->sef_name = safename($article->title);
        $article->is_featured = isset($form['is_featured']) ? $form['is_featured'] : false;
        $article->is_picked = isset($form['is_picked']) ? $form['is_picked'] : false;

        if( $article->is_featured )
        {
            $article->is_picked = false;
        }

        $article->is_active = isset($form['is_active']) ? $form['is_active'] : false;

        $article->save();

        if( !empty($form['locationId']) )
        {
            $location = [
                'channel_id' => $form['channel']
                ,'sub_channel_id' => $form['subChannel']
                ,'category_id' => $form['category']
            ];

            \DB::table('article_location')->whereId($form['locationId'])->update($location);
        }
        else
        {
            $location = [
                'article_id' => $article->id
                ,'channel_id' => $form['channel']
                ,'sub_channel_id' => $form['subChannel']
                ,'category_id' => $form['category']
            ];

            $articleLocation = new ArticleLocation($location);

            $articleLocation->save();
        }

        // temporary insert of a test asset

        \DB::table('article_asset')->where('article_id', $article->id)->delete();
        \DB::table('article_asset')->insert(['article_id' => $article->id, 'asset_id' => 1]);

        return $article;
    }

    public function countArticlesInCategory($categoryId, $channelId)
    {
        return ArticleLocation::where('category_id', $categoryId)->where('sub_channel_id', $channelId)->count();
    }

    public function getChannelArticleCategory($channelId)
    {
        return ArticleLocation::where('sub_channel_id', $channelId)->leftJoin('category', 'article_location.category_id', '=', 'category.id')->get()->toArray();
    }
}
