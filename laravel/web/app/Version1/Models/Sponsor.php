<?php namespace Version1\Models;

class Sponsor extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sponsor';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

        'impressions', 'clicks', 'is_mobile', 'is_tablet', 'is_desktop', 'is_deleted', 'created_at', 'updated_at', 'display_start', 'display_end'

    ];

    /**
    * The attributes of a user that can be manually set
    *
    * @var array
    */
    protected $fillable = [

        'image_id', 'title', 'url', 'display_start', 'display_end', 'impressions', 'clicks', 'is_mobile', 'is_table', 'is_desktop'

    ];

    /**
    * Form validation rules for a new user
    *
    * @var array
    */
    protected static $rules = [

        'title' => 'required'

    ];

    /**
    * relate the asset to a sponsor
    *
    * @return null
    */
    public function asset()
    {
        return $this->hasOne('\Version1\Models\Asset', 'id', 'image_id');
    }

    public static function getHomeSponsors()
    {
        return static::with('asset')->alive()->take(3)->get()->toArray();
    }
}
