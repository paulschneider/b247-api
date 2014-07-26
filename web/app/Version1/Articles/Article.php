<?php namespace Version1\Articles;

use Version1\Articles\ArticleLocation;
use Version1\Models\BaseModel;

class Article extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article';

    /**
     * The attributes excluded from the database response
     *
     * @var array
     */
    protected $hidden = [

        'content_type'
        , 'sponsor_id'
        , 'author_id'
        , 'is_deleted'
        , 'is_comments'
        , 'updated_at'
        , 'impressions'
        , 'is_approved'

    ];

    /**
    * The attributes of an article that can be manually set
    *
    * @var array
    */
    protected $fillable = [

        'content_type'
        , 'title'
        , 'sub_heading'
        , 'body'
        , 'postcode'
        , 'is_active'
        , 'is_featured'
        , 'is_picked'
        , 'is_promo'
        , 'is_approved'

    ];

    /**
    * Form validation rules for a new article
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
    protected $is_active = true;

    public function location()
    {
        return $this->hasMany('Version1\Articles\ArticleLocation', 'article_id')
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
                        , 'display_type.id AS displayTypeId'
                        , 'display_type.type AS displayType'
                    )
                    ->join('channel', 'channel.id', '=', 'article_location.channel_id')
                    ->join('channel AS subChannel', 'subChannel.id', '=', 'article_location.sub_channel_id')
                    ->join('category', 'category.id', '=', 'article_location.category_id')
                    ->join('article', 'article.id', '=', 'article_location.article_id')
                    ->join('display_type', 'subChannel.display_type', '=', 'display_type.id');
    }

    public function asset()
    {
        return $this->belongsToMany('\Version1\Models\Asset', 'article_asset', 'article_id');
    }

    public function event()
    {
        return $this->belongsTo('\Version1\Events\Event', 'event_id')->orderBy('event.show_date', 'asc');
    }

    public function venue()
    {
        return $this->belongsTo('\Version1\Venues\Venue', 'venue_id');   
    }

    public function video()
    {
        return $this->belongsToMany('\Version1\Videos\Video', 'article_video', 'article_id');
    }
}
