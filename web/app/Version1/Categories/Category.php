<?php namespace Version1\Categories;

use Version1\Models\BaseModel;
use Version1\Articles\Article;

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
        return $this->belongsToMany('\Version1\Channels\Channel', 'channel_category', 'channel_id', 'id', 'categories');
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
}
