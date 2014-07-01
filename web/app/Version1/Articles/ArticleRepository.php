<?php namespace Version1\Articles;

use Version1\Articles\ArticleInterface;
use Version1\Articles\ArticleLocation;
use Version1\Articles\ArticleType;
use Version1\Articles\Article;
use Version1\Models\BaseModel;
use \Carbon\Carbon;

Class ArticleRepository extends BaseModel implements ArticleInterface {

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

    public function getChannelListing( $channelId, $limit = 1000, $duration = 'week', $timestamp = null )
    {
        if ( is_null( $timestamp ) )
        {
            $timestamp = \time();
        }

        $dateStamp = convertTimestamp( 'Y-m-d', $timestamp );

        $query = Article::with(['location' => function($query) use ($channelId) {
                $query->where('article_location.sub_channel_id', $channelId);
        }])->with('asset')->with(['event' => function($query) {
                $query->orderBy('event.show_date', 'asc')->alive()->active();
        }])->with('event.venue');

        if( $duration == "week" )
        {
            $query->where('article.published', '>=', $dateStamp);
            $query->where('article.published', '<=', Carbon::today()->addWeeks(1));
        }
        elseif ( $duration == "day" )
        {
            $query->where('article.published', '=', $dateStamp);
        }

        $result = $query->orderBy('article.published', 'asc')->get()->toArray();

        $articles = [];

        foreach($result AS $article)
        {
            if( isset( $article['location'][0] ) )
            {
                array_push($articles, $article);
            }
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

    public function getArticles($type = 'article', $limit = 20, $channel = null, $subChannel = false)
    {
        $query = Article::with(['location' => function($query) use ($channel, $subChannel) {

            if( ! is_null($channel) )
            {
                if( ! $subChannel )
                {
                    $query->where('article_location.channel_id', $channel);
                }
                else
                {
                    $query->where('article_location.sub_channel_id', $channel);
                }
            }

        }])->with('asset');

        switch($type)
        {
            case 'picks' :
                $query->where('is_picked', '=', true)->where('is_featured', '=', false);
            break;
            case 'featured' :
                $query->where('is_featured', '=', true);
            break;
        }

        $result = $query->orderBy('article.created_at', 'desc')->get()->toArray();

        $articles = [];

        // check to see if the article location information was returned. If not then don't return the article

        $counter = 1;

        foreach( $result AS $article )
        {
            if( isset($article['location'][0]['locationId']) )
            {
                if( $counter <= $limit )
                {
                    $articles[] = $article;

                    $counter++;
                }
                else
                {
                    break;
                }
            }
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
}
