<?php namespace Apiv1\Repositories\Sponsors;

use Apiv1\Repositories\Models\BaseModel;
use Apiv1\Repositories\Sponsors\Sponsor;

class SponsorPlacement extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sponsor_placement';

    /**
    * The attributes of a user that can be manually set
    *
    * @var array
    */
    protected $fillable = [

        'sponsor_id', 'content_type', 'content_id'

    ];

    public function sponsor()
    {
        return $this->belongsToMany('Sponsor', 'sponsor_id', 'id');
    }
}
