<?php

namespace Version1\Models;

class UserProfile extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'user_profile';

    /**
    * Array of white listed items
    *
    * @var string
    */
    protected $fillable = [ 'facebook', 'twitter', 'lat', 'lon', 'area', 'updated_at' ];

    /**
    * Array of items not to be returned
    *
    * @var string
    */
    protected $hidden = [ 'id', 'user_id', 'updated_at' ];

    /**
    * Array of items not to be over-written
    *
    * @var string
    */
    protected $guarded = [ 'id', 'user_id' ];

    /**
     * Relate a user profile to a user
     *
     * @return ???
     */
    public function user()
    {
        return $this->belongsTo('\Version1\Models\User');
    }
}
