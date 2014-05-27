<?php

namespace Version1\Models;

Class SubChannel extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'channel';

    /**
    * Array of white listed items
    *
    * @var string
    */
    protected $fillable = [ 'icon_img_id', 'name', 'sef_name', 'colour', 'created_at', 'updated_at' ];

    /**
    * Array of items not to be returned
    *
    * @var string
    */
    protected $hidden = [ 'is_active', 'is_deleted', 'created_at', 'updated_at', 'colour' ];

    /**
     * Relate categories to their parent sub-channels
     *
     * @return ???
     */
    public function category()
    {
        return $this->belongsToMany('\Version1\Models\Category', 'channel_category', 'channel_id');
    }

    /**
     * Relate sub-channel to parent channel
     *
     * @return ???
     */
    public function channel()
    {
        return $this->belongsToMany('\Version1\Models\Channel', 'parent_id', 'id');
    }
}
