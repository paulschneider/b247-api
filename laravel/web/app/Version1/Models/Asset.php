<?php namespace Version1\Models;

class Asset extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'asset';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

        'created_at', 'updated_at'

    ];

    /**
    * The attributes of a user that can be manually set
    *
    * @var array
    */
    protected $fillable = [

        'filepath', 'alt', 'title', 'width', 'height', 'filesize'

    ];

    /**
    * Form validation rules for a new user
    *
    * @var array
    */
    protected static $rules = [];

    /**
    * relate the asset to a sponsor
    *
    * @return null
    */
    public function sponsor()
    {
        return $this->belongsTo('sponsor', 'image_id');
    }
}
