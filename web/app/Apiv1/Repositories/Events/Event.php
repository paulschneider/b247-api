<?php namespace Apiv1\Repositories\Events;

use Apiv1\Repositories\Models\BaseModel;

Class Event extends BaseModel {

    protected $table = 'event';

    public $is_active = true;

    public function venue()
    {
        return $this->belongsTo('Apiv1\Repositories\Venues\Venue', 'venue_id');
    }   
   
    public function showTime()
    {
        return $this->hasMany('Apiv1\Repositories\Events\ShowTime', 'event_id')->orderBy('showtime', 'desc');
    }

    public function cinema()
    {
        return $this->hasOne('Apiv1\Repositories\Events\Cinema', 'event_id');
    }
}
