<?php namespace Apiv1\Repositories\Channels;

use Apiv1\Repositories\Models\BaseModel;

Class ChannelCategory extends BaseModel
{
    protected $table = "channel_category";

    protected $fillable = [ 'channel_id', 'category_id' ];

    protected $hidden = [ 'id', 'channel_id' ];

    public $timestamps = false;

    public function categoryChannel()
    {
        return $this->belongsToMany('Apiv1\Repositories\Channels\Channel', 'channel_id', 'parent_channel');
    }

    public function category()
    {
        return $this->belongsTo('Apiv1\Repositories\Categories\Category', 'category_id', 'id');
    }
}
