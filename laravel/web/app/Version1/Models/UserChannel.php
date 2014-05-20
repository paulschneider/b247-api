<?php

namespace Version1\Models;

Class UserChannel extends \Eloquent
{
    protected $table = 'user_channel';

    protected $guarded = [ 'id' ];

    public function User()
    {
        $this->belongsTo('\Version1\Models\User');
    }
}
