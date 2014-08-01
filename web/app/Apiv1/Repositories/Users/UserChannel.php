<?php namespace Apiv1\Repositories\Models;

Class UserChannel extends \Eloquent
{
    protected $table = 'user_channel';

    protected $guarded = [ 'id' ];

    public $timestamps = false;

    public function User()
    {
        $this->belongsTo('Apiv1\Repositories\Users\User');
    }
}
