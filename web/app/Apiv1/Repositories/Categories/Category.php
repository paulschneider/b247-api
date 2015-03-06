<?php namespace Apiv1\Repositories\Categories;

use Apiv1\Repositories\Models\BaseModel;

Class Category extends BaseModel
{
    protected $table = 'category';

    # Hide the fields we don't ever want to come out into the API
    protected $hidden = [ 'colour', 'content_type', 'is_active', 'is_deleted', 'created_at', 'updated_at' ];

    /**
    * relate the category to a channel
    *
    * @var  mixed
    */
    public function channel()
    {
        return $this->belongsToMany('Apiv1\Repositories\Channels\Channel', 'channel_category', 'channel_id', 'id', 'categories');
    }

    /**
    * relate the category to articles
    *
    * @var  mixed
    */
    public function article()
    {
        return $this->hasMany('Apiv1\Repositories\Articles\Article');
    }
}
