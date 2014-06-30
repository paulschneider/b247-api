<?php namespace Version1\Articles;

use \Version1\Models\BaseModel;
use \Version1\Articles\Article;

class ArticleLocation extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article_location';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'id' ];

    /**
    * The attributes that can be manually set
    *
    * @var array
    */
    protected $fillable = [

        'article_id', 'category_id', 'channel_id', 'sub_channel_id'

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

    public function article()
    {
        return $this->belongsToMany('article', 'article_location', 'article_id');
    }
}
