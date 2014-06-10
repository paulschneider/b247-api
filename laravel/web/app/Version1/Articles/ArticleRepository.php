<?php namespace Version1\Articles;

use \Version1\Articles\ArticleInterface;
use \Version1\Articles\ArticleLocation;
use \Version1\Articles\Article;
use \Version1\Models\BaseModel;

Class ArticleRepository extends BaseModel implements ArticleInterface {

    public function getArticle($identifier)
    {
        $query = Article::with('location')->with('asset');

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

    public function getArticles($type = null, $limit = 20, $channel = null)
    {
        $query = Article::with(['location' => function($query) use ($channel) {

            if( ! is_null($channel) )
            {
                $query->where('article_location.channel_id', $channel);
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

        return $query->take($limit)->orderBy('article.created_at', 'desc')->get()->toArray();
    }

    public function getArticlesWithEvents($type, $channel = 50)
    {
        $query = Article::with('asset')->with(['location' => function($query) use($channel) {
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
