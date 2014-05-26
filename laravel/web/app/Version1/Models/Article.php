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

        'content_type', 'sponsor_id', 'event_id', 'author_id', 'is_active', 'is_deleted', 'is_comments', 'created_at', 'updated_at', 'impressions', 'is_approved'

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
        return $this->hasOne('\Version1\Models\ArticleLocation', 'article_id')->select( ['article_id', 'channel_id', 'sub_channel_id', 'cat_id'] );
    }

    public static function getArticle($id)
    {
        return parent::dataCheck(\DB::table('article')
                    ->select('article.title'
                            , 'article.sef_name AS articleSefName'
                            , 'channel.sef_name AS channelSefName'
                            , 'subChannel.sef_name AS subChannelSefName'
                            , 'category.sef_name AS categorySefName'
                    )
                    ->join('article_location AS location', 'location.article_id', '=', 'article.id')
                    ->join('channel', 'channel.id', '=', 'location.channel_id')
                    ->join('channel AS subChannel', 'subChannel.id', '=', 'location.sub_channel_id')
                    ->join('category', 'category.id', '=', 'location.category_id')
                    ->where('article.id', $id)
                    ->get());
    }

    public static function getPicks()
    {
        return static::isPicked()->notFeatured()->orderBy('title')->take(10)->get()->toArray();
    }

    public static function getFeatured()
    {
        return static::isFeatured()->orderBy('title')->take(10)->get()->toArray();
    }

    public function scopeIsFeatured($query)
    {
        return $query->where('is_featured', '=', true);
    }

    public function scopeNotPicked($query)
    {
        return $query->where('is_picked', '=', false);
    }

    public function scopeIsPicked($query)
    {
        return $query->where('is_picked', '=', true);
    }

    public function scopeNotFeatured($query)
    {
        return $query->where('is_featured', '=', false);
    }
}
