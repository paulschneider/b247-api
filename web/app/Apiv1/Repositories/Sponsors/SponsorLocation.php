<?php namespace Apiv1\Repositories\Sponsors;

use Apiv1\Repositories\Models\BaseModel;

class SponsorLocation extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sponsor_location';

    /**
     * sponsor relationship
     * @return mixed
     */
    public function sponsor()
    {
        return $this->belongsToMany('Apiv1\Repositories\Sponsors\Sponsor', 'sponsor_location', 'id', 'sponsor_id');
    }
}
