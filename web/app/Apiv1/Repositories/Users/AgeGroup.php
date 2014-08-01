<?php namespace Apiv1\Repositories\Users;

Class AgeGroup extends \Eloquent
{
    protected $table = 'age_group';

    // Hide the fields we don't ever want to come out into the API
    protected $hidden = [ 'id' ];

    // which fields will we allow to be written
    protected $fillable = [ 'range' ];

    public $timestamps = false;
}
