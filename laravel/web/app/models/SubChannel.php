<?php

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
    protected $fillable = [ 'content_type', 'icon_img_id', 'name', 'sef_name', 'colour', 'created_at', 'updated_at' ];

    /**
    * Array of items not to be returned
    *
    * @var string
    */
    protected $hidden = [ 'is_active', 'is_deleted', 'created_at', 'updated_at', 'content_type', 'parent_channel', 'colour' ];

    /**
     * Relate categories to their parent sub-channels
     *
     * @return ???
     */
    public function channelCategory()
    {
        return $this->hasMany('ChannelCategory', 'channel_id', 'id');
    }

    public function channel()
    {
        return $this->belongsToMany('Channel', 'parent_id', 'id');
    }
}
