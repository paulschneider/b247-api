<?php namespace Version1\Sponsors;

use Version1\Models\BaseModel;
use Version1\Channels\Channel;

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

        'is_mobile', 'is_tablet', 'is_desktop', 'is_deleted', 'created_at', 'updated_at'

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
    * Form validation rules for a new sponsor
    *
    * @var array
    */
    protected static $rules = [

        'title' => 'required'
        ,'url' => 'required'

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

    public function channel()
    {
        return $this->belongsToMany('Version1\Channels\Channel', 'sponsor_placement', 'sponsor_id', 'id');
    }

    public function displayStyle()
    {
        return $this->belongsTo('\Version1\Models\DisplayStyle', 'display_style');
    }
}
