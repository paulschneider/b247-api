<?php namespace Apiv1\Repositories\Promotions;

use Apiv1\Repositories\Models\BaseModel;

class CompetitionQuestions extends BaseModel
{
    protected $table = "competition_question";

    public function answers()
    {
    	return $this->hasMany('Apiv1\Repositories\Promotions\CompetitionAnswers', 'competition_id')->orderBy('answer', 'asc');
    }
}
