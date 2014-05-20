<?php

Class BaseModel extends Eloquent
{
    protected $guarded = ['id'];

    protected $fillable = array('content_type', 'icon_img_id', 'name', 'sef_name', 'colour', 'created_at', 'updated_at');

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAlive($query)
    {
        return $query->where('is_deleted', null);
    }
}
