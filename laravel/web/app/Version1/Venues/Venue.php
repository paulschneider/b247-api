<?php namespace Version1\Venues;

use \Version1\Models\BaseModel;

Class Venue extends BaseModel {

    protected $table = 'venue';

    public $is_active = true;

    /**
    * Form validation rules for a new event
    *
    * @var array
    */
    protected static $rules = [

        'name' => 'required'
        ,'sef_name' => 'required'
        ,'address_line_1' => 'required'
        ,'address_line_2' => 'required'
        ,'address_line_3' => 'required'
        ,'postcode' => 'required'
        ,'email' => 'required'

    ];

    public function events()
    {
        return $this->hasMany('Version1\EventsListing\Events');
    }
}
