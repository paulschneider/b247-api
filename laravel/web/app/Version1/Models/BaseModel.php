<?php namespace Version1\Models;

use Eloquent;
use Validator;

Class BaseModel extends \Eloquent
{
    protected $guarded = ['id'];

    protected $fillable = array('content_type', 'icon_img_id', 'name', 'sef_name', 'colour', 'created_at', 'updated_at');

    public $errors;

    public static function boot()
    {
        parent::boot();


        static::saving(function($model)
        {

            return $model->validate();

        });

    }

    public function validate()
    {

        $validation = Validator::make($this->getAttributes(), static::$rules);

        if($validation->fails())
        {

            $this->errors = $validation->messages()->toArray();

            return false;

        }

        return true;

    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAlive($query)
    {
        return $query->where('is_deleted', null);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
