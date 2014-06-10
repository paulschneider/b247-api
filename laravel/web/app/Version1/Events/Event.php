<?php namespace Version1\Events;

use \Version1\Models\BaseModel;

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
        return $this->belongsTo('\Version1\Venues\Venue');
    }

    public function article()
    {
        return $this->hasMany('\Version1\Articles\Article', 'event_id');
    }
}
