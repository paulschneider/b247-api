<?php

Class Channel extends Eloquent
{
    protected $table = 'channel';

    protected $fillable = [ 'content_type', 'icon_img_id', 'name', 'sef_name', 'colour', 'created_at', 'updated_at' ];

    protected $hidden = [ 'is_active', 'is_deleted', 'created_at', 'updated_at', 'content_type', 'parent_channel' ];

    public function subChannel()
    {
        return $this->hasMany('SubChannel', 'parent_channel')->active()->alive();
    }
}
