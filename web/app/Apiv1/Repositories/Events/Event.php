<?php namespace Apiv1\Repositories\Events;

use Apiv1\Repositories\Models\BaseModel;

Class Event extends BaseModel {

    protected $table = 'event';

    public $is_active = true;

    /**
    * Form validation rules for a new event
    *
    * @var array
    */
    protected static $rules = [

        'title' => 'required'
        ,'venue_id' => 'required'
        ,'sef_name' => 'required'
        ,'show_date' => 'required'
        ,'show_time' => 'required'
        ,'price' => 'required'
        ,'url' => 'required'

    ];

    public function venue()
    {
        return $this->belongsTo('Apiv1\Repositories\Venues\Venue', 'venue_id');
    }

    public function article()
    {
        return $this->hasMany('Apiv1\Repositories\Articles\Article', 'event_id')->active()->notFeatured()->notPicked()->alive();
    }
}
