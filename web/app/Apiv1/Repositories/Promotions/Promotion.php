<?php namespace Apiv1\Repositories\Promotions;

use Apiv1\Repositories\Models\BaseModel;

class Promotion extends BaseModel
{
    protected $table = "promotion";

    public function article()
    {
    	$this->belongsTo('Apiv1\Repositories\Articles\Article', 'article_promotion', 'promotion_id', 'id');
    }

    public function usage()
    {
    	return $this->hasMany('Apiv1\Repositories\Promotions\UserRedeemedPromotion', 'promotion_id');
    }
}
