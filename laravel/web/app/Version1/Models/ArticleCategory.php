<?php namespace Version1\Models;

class ArticleCategory extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article_category';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

        'article_id', 'cat_id'

    ];

    /**
    * The attributes that can be manually set
    *
    * @var array
    */
    protected $fillable = [

        'article_id', 'cat_id'

    ];

    /**
    * validation rules for this class
    *
    * @var array
    */
    static $rules = [];

    /**
    * enable or disable timestamp usage for this class
    *
    * @var boolean
    */
    public $timestamps = false;
}
