<?php namespace Version1\Channels;

use Version1\Channels\Channel;
use Version1\Channels\Category;
use Version1\Models\BaseModel;

Class ChannelCategory extends BaseModel
{
    protected $table = "channel_category";

    protected $fillable = [ 'channel_id', 'category_id' ];

    protected $hidden = [ 'id', 'channel_id' ];

    public $timestamps = false;

    public function categoryChannel()
    {
        return $this->belongsToMany('Channel', 'channel_id', 'parent_channel');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id');
    }
}
