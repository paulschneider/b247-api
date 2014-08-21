<?php namespace Apiv1\Repositories\Users;

use Apiv1\Repositories\Models\BaseModel;

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

        'age_group_id', 'facebook', 'twitter', 'lat', 'lon', 'area', 'updated_at' 

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
        return $this->belongsTo('Apiv1\Repositories\Users\User');
    }
}
