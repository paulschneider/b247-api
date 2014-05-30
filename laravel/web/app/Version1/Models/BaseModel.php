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
        return $query->where($field . 'is_deleted', null);
    }

    public function scopeNotFeatured($query, $field = '')
    {
        return $query->where($field . 'is_featured', false);
    }

    public function scopeNotPicked($query, $field = '')
    {
        return $query->where($field . 'is_picked', null);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public static function dataCheck($data)
    {
        if( is_array($data) )
        {
            if( count($data) > 0)
            {
                if(count($data) == 1)
                {
                    return $data[0];
                }

                return $data;
            }
        }
        else if( $data instanceOf \stdClass )
        {
            return $data;
        }
        else if( method_exists($data, 'count') )
        {
            if( $data->count() > 0 )
            {
                return $data->toArray();
            }
        }

        throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
    }
}
