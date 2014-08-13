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
        return $this->hasMany('Apiv1\Repositories\Events\ShowTime', 'event_id');
    }

    public function article()
    {
        return $this->hasMany('Apiv1\Repositories\Articles\Article', 'event_id')->active()->notFeatured()->notPicked()->alive();
    }
}
