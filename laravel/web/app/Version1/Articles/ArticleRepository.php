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
        $query = Article::with('location', 'asset', 'type', 'displayStyle');

        if( is_numeric($identifier) )
        {
            $query->where('article.id', '=', $identifier);
        }
        else
        {
            $query->where('article.sef_name', '=', $identifier);
        }

        return parent::dataCheck($query->first()->toArray());
    }

    public function getArticleTypes()
    {
        return ArticleType::lists('type', 'id');
    }

    public function getChannelArticlesbyDate($channelId, $limit = 20, $listingTransformer, $articleTransformer)
    {
        $query = Article::with(['location' => function($query) use ($channelId) {
                $query->where('article_location.sub_channel_id', $channelId);
        }])->with('asset', 'type', 'displayStyle');

        $query->where('article.published', '>=', Carbon::today());
        $query->where('article.published', '<=', Carbon::today()->addWeeks(1));

        $result = $query->take($limit)
                        ->orderBy('article.published', 'asc')
                        ->get()
                        ->toArray();

        $articles = [];

        foreach( $result AS $article )
        {
            // check to see if the article location information was returned. If not then don't return the article

            if( isset($article['location'][0]['locationId']) )
            {
                $location = $article['location'][0];

                $key = date('d-m-Y', strtotime($article['published']));

                $articles[ $key ]['publication'] = [
                    'date' => $article['published']
                    ,'day' => date('D', strtotime($article['published']))
                    ,'fullDay' => date('l', strtotime($article['published']))
                    ,'iso8601Date' => date('c', strtotime($article['published']))
                ];

                $articles[ $key ]['categories'][$location['categoryId']] = [
                    'categoryId' => $location['categoryId']
                    ,'categoryName' => $location['categoryName']
                    ,'categorySefName' => $location['categorySefName']
                    ,'path' => $location['channelSefName'] . '/' . $location['subChannelSefName'] . '/' . $location['categorySefName']
                ];

                $articles[ $key ]['articles'][] = $articleTransformer->transform($article);
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
            if( ! $article['is_featured'] and ! $article['is_picked'] and ! $article['is_promo'] and empty($article['event_id']) )
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
                    $response[$subChannel['subChannelSefName']]['articles'][] = $articleTransformer->transform($article);
                }
            }
        }

        return $response;
    }

    public function getArticles($type = null, $limit = 20, $channel = null, $subChannel = false)
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

        }])->with('asset', 'type', 'displayStyle');

        switch($type)
        {
            case 'picks' :
                $query->where('is_picked', '=', true)->where('is_featured', '=', false);
            break;
            case 'promos' :
                $query->where('is_promo', '=', true)->where('is_featured', '=', false);
            break;
            case 'featured' :
                $query->where('is_featured', '=', true);
            break;
        }

        $result = $query->take($limit)->orderBy('article.created_at', 'desc')->get()->toArray();

        $articles = [];

        // check to see if the article location information was returned. If not then don't return the article

        foreach( $result AS $article )
        {
            if( isset($article['location'][0]['locationId']) )
            {
                $articles[] = $article;
            }
        }

        return $articles;
    }

    public function getArticlesWithEvents($type, $channel = 50)
    {
        $query = Article::with('asset', 'displayStyle')->with(['location' => function($query) use($channel) {
                $query->where('article_location.channel_id', $channel);
        }])->with(['event' => function($query) {
                $query->orderBy('event.show_date', 'asc')->alive()->active();
        }]);

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

        $article->article_type_id = ! empty($form['type']) ? $form['type'] : null;
        $article->display_type = ! empty($form['display_style']) ? $form['display_style'] : $article->display_style;
        $article->event_id = ! empty($form['event']) ? $form['event'] : null;
        $article->sef_name = safename($article->title);
        $article->is_featured = isset($form['is_featured']) ? $form['is_featured'] : false;
        $article->is_picked = isset($form['is_picked']) ? $form['is_picked'] : false;
        $article->is_promo = isset($form['is_promo']) ? $form['is_promo'] : false;

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
