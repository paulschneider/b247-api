<?php

namespace Version1\Models;

Class Category extends BaseModel
{
    protected $table = 'category';

    // Hide the fields we don't ever want to come out into the API
    protected $hidden = [ 'colour', 'content_type', 'is_active', 'is_deleted', 'created_at', 'updated_at' ];

    public function channel()
    {
        return $this->belongsToMany('\Version1\Models\ChannelCategory', 'channel_category', 'channel_id', 'id', 'categories');
    }

    public function article()
    {
        return $this->hasMany('\Version1\Models\Article');
    }

    public static function getSimpleCategories()
    {
        return static::active()->alive()->lists('name', 'id');
    }

}
