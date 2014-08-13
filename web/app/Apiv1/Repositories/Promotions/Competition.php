<?php namespace Apiv1\Repositories\Promotions;

use Apiv1\Repositories\Models\BaseModel;

class Competition extends BaseModel
{
    protected $table = "competition";

    public function questions()
    {
    	return $this->hasMany('Apiv1\Repositories\Promotions\CompetitionQuestions', 'competition_id');
    }
}
