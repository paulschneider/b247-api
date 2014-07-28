<?php namespace Apiv1\Repositories\Models;

use Eloquent;
use Validator;

Class BaseModel extends Eloquent
{
    protected $guarded = ['id'];

    protected $fillable = array('content_type', 'icon_img_id', 'name', 'sef_name', 'colour', 'created_at', 'updated_at');

    public $timestamps = true;

    public $errors;

    public function scopeActive($query, $field = '')
    {
        return $query->where($field . 'is_active', true);
    }

    public function scopeCreatedDescending($query, $field = '')
    {
        return $query->orderBy($field . 'created_at', 'desc');
    }

    public function scopeAlive($query, $field = '')
    {
        return $query->where($field . 'is_deleted', null)->orWhere($field . 'is_deleted', false);
    }

    public function scopeNotFeatured($query, $field = '')
    {
        return $query->where($field . 'is_featured', 0);
    }

    public function scopeNotPicked($query, $field = '')
    {
        return $query->where($field . 'is_picked', 0);
    }
}
