<?php

Class ChannelCategory extends Eloquent
{
    protected $table = "channel_category";

    protected $fillable = [ 'channel_id', 'category_id' ];

    protected $hidden = [ 'id', 'channel_id', 'category_id' ];

    public $timestamps = false;

    public function categoryChannel()
    {
        return $this->belongsToMany('Channel', 'channel_id');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id');
    }
}
