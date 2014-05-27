<?php

namespace Version1\Models;

Class Category extends BaseModel
{
    protected $table = 'category';

    // Hide the fields we don't ever want to come out into the API
    protected $hidden = [ 'colour', 'content_type', 'is_active', 'is_deleted', 'created_at', 'updated_at' ];

    // ste the default active status for a new category
    public $is_active = true;

    /**
    * relate the category to a channel
    *
    * @var  ???
    */
    public function channel()
    {
        return $this->belongsToMany('\Version1\Models\Channel', 'channel_category', 'channel_id', 'id', 'categories');
    }

    /**
    * Form validation rules for a new category
    *
    * @var array
    */
    protected static $rules = [

        'name' => 'required'

    ];

    /**
    * relate the category to articles
    *
    * @var  ???
    */
    public function article()
    {
        return $this->hasMany('\Version1\Models\Article');
    }

    /**
    * get a simple array containing categories and their ID's
    *
    * @var  ???
    */
    public static function getSimpleCategories()
    {
        return static::active()->alive()->lists('name', 'id');
    }

    /**
    * store the details of a category in the DB
    *
    * @var  ???
    */
    public static function storeCategory($form)
    {
        if( !empty($form['id']) )
        {
            $category = static::find($form['id']);
        }
        else
        {
            $category = new \Version1\Models\Category();
        }

        $category->name = $form['name'];
        $category->sef_name = safename($form['name']);
        $category->is_active = $form['is_active'];

        $category->save();

        return $category;
    }
}
