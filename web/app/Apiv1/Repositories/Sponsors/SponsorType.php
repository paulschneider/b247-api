<?php namespace Apiv1\Repositories\Sponsors;

use Apiv1\Repositories\Models\BaseModel;

class SponsorType extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sponsor_type';

    /**
     * sponsor relationship
     * @return mixed
     */
    public function sponsor()
    {
        return $this->belongsTo('Apiv1\Repositories\Sponsors\Sponsor');
    }
}
