<?php namespace Version1\Users;

use Version1\Models\BaseModel;

class UserProfile extends BaseModel
{   
    public $timestamps = false;

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
    protected $fillable = [

        'age_group_id', 'nickname', 'facebook', 'twitter', 'lat', 'lon', 'area', 'updated_at' 

    ];

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
