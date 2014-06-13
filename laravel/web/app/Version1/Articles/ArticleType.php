<?php namespace Version1\Articles;

use Version1\Models\BaseModel;

Class ArticleType extends BaseModel
{
    protected $fillable = [ 'type', 'updated_at' ];

    protected $table = 'article_type';

    public function article()
    {
        return $this->belongsTo('Version1\Articles\Article');
    }
}
