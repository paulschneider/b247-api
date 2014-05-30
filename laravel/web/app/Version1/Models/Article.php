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

        'content_type', 'sponsor_id', 'event_id', 'author_id','is_deleted', 'is_comments', 'updated_at', 'impressions', 'is_approved'

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

    /**
    * default status for new articles
    *
    * @var int
    */
    public $is_active = true;

    public function location()
    {
        return $this->hasMany('\Version1\Models\ArticleLocation', 'article_id')
                    ->select(
                        'article_location.id AS locationId'
                        , 'channel_id AS channelId'
                        , 'channel.name AS channelName'
                        , 'channel.sef_name AS channelSefName'
                        , 'sub_channel_id AS subChannelId'
                        , 'subChannel.name AS subChannelName'
                        , 'subChannel.sef_name AS subChannelSefName'
                        , 'category_id AS categoryId'
                        , 'category.name AS categoryName'
                        , 'category.sef_name AS categorySefName'
                        , 'article_id'
                        , 'article.is_active'
                        , 'article.is_deleted'
                        , 'article.is_featured'
                        , 'article.is_picked'
                    )
                    ->join('channel', 'channel.id', '=', 'article_location.channel_id')
                    ->join('channel AS subChannel', 'subChannel.id', '=', 'article_location.sub_channel_id')
                    ->join('category', 'category.id', '=', 'article_location.category_id')
                    ->join('article', 'article.id', '=', 'article_location.article_id');
    }

    public function asset()
    {
        return $this->belongsToMany('\Version1\Models\Asset', 'article_asset', 'article_id');
    }

    public static function getArticle($identifier)
    {
        $query = static::with('location')->with('asset');

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

    public static function getArticles($type = null, $limit = 20, $channel = null)
    {
        $query = static::with(['location' => function($query) use ($channel) {
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
        $article->sef_name = safename($article->title);
        $article->sub_heading = $form['sub_heading'];
        $article->body = $form['body'];
        $article->postcode = $form['postcode'];
        $article->is_active = isset($form['is_active']) ? true : false;
        $article->is_featured = isset($form['is_featured']) ? $form['is_featured'] : false;
        $article->is_picked = isset($form['is_picked']) ? $form['is_picked'] : false;

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

        // temporary insert of a test asset

        \DB::table('article_asset')->where('article_id', $article->id)->delete();
        \DB::table('article_asset')->insert(['article_id' => $article->id, 'asset_id' => 1]);

        return $article;
    }
}
