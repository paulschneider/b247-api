<?php namespace Apiv1\Repositories\Venues;

use Apiv1\Repositories\Models\BaseModel;

Class Venue extends BaseModel {

    protected $table = 'venue';

    public function events()
    {
        return $this->hasMany('Apiv1\Repositories\Events\Event');
    }
}
