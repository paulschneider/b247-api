<?php namespace Version1\Models;

class Article extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

        'content_type', 'sponsor_id', 'event_id', 'author_id','is_deleted', 'is_comments', 'created_at', 'updated_at', 'impressions', 'is_approved'

    ];

    /**
    * The attributes of a user that can be manually set
    *
    * @var array
    */
    protected $fillable = [

        'content_type', 'title', 'sub_heading', 'body', 'postcode', 'is_active', 'is_featured', 'is_picked', 'is_approved'

    ];

    /**
    * Form validation rules for a new user
    *
    * @var array
    */
    protected static $rules = [

        'title' => 'required'
        ,'body' => 'required'

    ];

    public function location()
    {
        return $this->hasMany('\Version1\Models\ArticleLocation', 'article_id')->select('article_id', 'channel_id', 'sub_channel_id', 'category_id');
    }

    public static function getArticle($id)
    {
        return parent::dataCheck(\DB::table('article')
                    ->select(
                            'article.id'
                            , 'article.title'
                            , 'article.sub_heading'
                            , 'article.body'
                            , 'article.postcode'
                            , 'article.sef_name AS articleSefName'
                            , 'article.is_active'
                            , 'article.is_picked'
                            , 'article.is_featured'
                            , 'article.created_at'
                            , 'location.id AS locationId'
                            , 'channel.id AS channelId'
                            , 'channel.name AS channelName'
                            , 'channel.sef_name AS channelSefName'
                            , 'subChannel.id AS subChannelId'
                            , 'subChannel.name AS subChannelName'
                            , 'subChannel.sef_name AS subChannelSefName'
                            , 'category.id AS categoryId'
                            , 'category.name AS categoryName'
                            , 'category.sef_name AS categorySefName'
                            , 'asset.filepath'
                            , 'asset.alt'
                            , 'asset.title AS assetTitle'
                            , 'asset.width'
                            , 'asset.height'
                    )
                    ->join('article_location AS location', 'location.article_id', '=', 'article.id')
                    ->join('channel', 'channel.id', '=', 'location.channel_id')
                    ->join('channel AS subChannel', 'subChannel.id', '=', 'location.sub_channel_id')
                    ->join('category', 'category.id', '=', 'location.category_id')
                    ->leftJoin('article_asset', 'article_asset.article_id', '=', 'article.id')
                    ->leftJoin('asset', 'asset.id', '=', 'article_asset.asset_id')
                    ->where('article.id', $id)
                    ->first());
    }

    public static function getArticles($type = null, $limit = 20)
    {
        $query = \DB::table('article')
                    ->select( 'article.id'
                            , 'article.title'
                            , 'article.sef_name AS articleSefName'
                            , 'article.is_picked'
                            , 'article.is_featured'
                            , 'article.created_at'
                            , 'channel.id AS channelId'
                            , 'channel.name AS channelName'
                            , 'channel.sef_name AS channelSefName'
                            , 'subChannel.id AS subChannelId'
                            , 'subChannel.name AS subChannelName'
                            , 'subChannel.sef_name AS subChannelSefName'
                            , 'category.id AS categoryId'
                            , 'category.name AS categoryName'
                            , 'category.sef_name AS categorySefName'
                            , 'asset.filepath'
                            , 'asset.alt'
                            , 'asset.title AS assetTitle'
                            , 'asset.width'
                            , 'asset.height'
                            )
                    ->join('article_location AS location', 'location.article_id', '=', 'article.id')
                    ->join('channel', 'channel.id', '=', 'location.channel_id')
                    ->join('channel AS subChannel', 'subChannel.id', '=', 'location.sub_channel_id')
                    ->join('category', 'category.id', '=', 'location.category_id')
                    ->leftJoin('article_asset', 'article_asset.article_id', '=', 'article.id')
                    ->leftJoin('asset', 'asset.id', '=', 'article_asset.asset_id')
                    ->orderBy('article.title')
                    ->take($limit);

        switch($type)
        {
            case 'picks' :
                $query->where('is_picked', '=', true)->where('is_featured', '=', false);
            break;
            case 'featured' :
                $query->where('is_featured', '=', true);
            break;
        }

        return $query->get();
    }

    public static function storeArticle($form)
    {
        if( !empty($form['id']) )
        {
            $article = static::find($form['id']);
        }
        else
        {
            $article = new \Version1\Models\Article();
        }

        $article->title = $form['title'];
        $article->sef_name = safename($form['title']);
        $article->sub_heading = $form['sub_heading'];
        $article->body = $form['body'];
        $article->postcode = $form['postcode'];
        $article->is_active = $form['is_active'];

        if( isset($form['is_featured']) )
        {
            $article->is_featured = $form['is_featured'];
        }

        if( isset($form['is_picked']) )
        {
            $article->is_picked = $form['is_picked'];
        }

        if( $article->is_featured )
        {
            $article->is_picked = false;
        }

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

            $articleLocation = new \Version1\Models\ArticleLocation($location);

            $articleLocation->save();
        }

        return $article;
    }
}
