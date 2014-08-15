<?php namespace Apiv1\Repositories\Events;

use Apiv1\Repositories\Models\BaseModel;

Class ShowTime extends BaseModel {

    protected $table = 'event_showtimes';

    public function Event()
    {
        return $this->hasMany('Apiv1\Repositories\Events\Event');
    }

    public function venue()
    {
    	return $this->hasOne('Apiv1\Repositories\Venues\Venue', 'id', 'venue_id');
    }
}
