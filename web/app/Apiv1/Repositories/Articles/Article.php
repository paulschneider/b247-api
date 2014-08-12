<?php namespace Apiv1\Repositories\Articles;

use Apiv1\Repositories\Models\BaseModel;

class Article extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article';

    public function location()
    {
        return $this->hasMany('Apiv1\Repositories\Articles\ArticleLocation', 'article_id')
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
        return $this->belongsToMany('Apiv1\Repositories\Models\Asset', 'article_asset', 'article_id')->where('image_type', '=', 1);
    }

    public function gallery()
    {
        return $this->belongsToMany('Apiv1\Repositories\Models\Asset', 'article_asset', 'article_id')->where('image_type', '!=', 1);
    }

    public function event()
    {
        return $this->belongsTo('Apiv1\Repositories\Events\Event', 'event_id');
    }

    public function venue()
    {
        return $this->belongsToMany('Apiv1\Repositories\Venues\Venue', 'article_venue', 'article_id');   
    }

    public function video()
    {
        return $this->belongsToMany('Apiv1\Repositories\Videos\Video', 'article_video', 'article_id');
    }

    public function author()
    {
        return $this->belongsToMany('Apiv1\Repositories\Articles\Author', 'article_author', 'article_id');
    }

    public function promotion()
    {
        return $this->belongsToMany('Apiv1\Repositories\Promotions\Promotion', 'article_promotion', 'article_id', 'promotion_id');
    }
}
