<?php

Class Category extends Eloquent
{
    protected $table = 'category';

    // Hide the fields we don't ever want to come out into the API
    protected $hidden = [ 'colour', 'content_type', 'is_active', 'is_deleted', 'created_at', 'updated_at' ];

    public function channel()
    {
        return $this->belongsToMany('ChannelCategory', 'channel_category', 'channel_id', 'id', 'categories');
    }

}
