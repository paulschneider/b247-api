<?php namespace Apiv1\Repositories\Articles;

use Apiv1\Repositories\Models\BaseModel;

class ArticleLocation extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'article_location';

    public function article()
    {
        return $this->hasOne('Apiv1\Repositories\Articles\Article', 'id', 'article_id', 'id');
    }
}
