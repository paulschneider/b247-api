<?php namespace Apiv1\Repositories\Promotions;

use Apiv1\Repositories\Models\BaseModel;

class Promotion extends BaseModel
{
    protected $table = "promotion";

    public function article()
    {
    	$this->belongsTo('Apiv1\Repositories\Articles\Article', 'article_promo', 'promo_id', 'id');
    }
}
