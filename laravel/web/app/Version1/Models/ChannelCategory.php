<?php

namespace Version1\Models;

Class ChannelCategory extends \Eloquent
{
    protected $table = "channel_category";

    protected $fillable = [ 'channel_id', 'category_id' ];

    protected $hidden = [ 'id', 'channel_id' ];

    public $timestamps = false;

    public function categoryChannel()
    {
        return $this->belongsToMany('\Version1\Models\Channel', 'channel_id', 'parent_channel');
    }

    public function category()
    {
        return $this->belongsTo('\Version1\Models\Category', 'category_id', 'id');
    }
}
