<?php namespace Apiv1\Repositories\Sponsors;

use Apiv1\Repositories\Models\BaseModel;

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
        return $this->hasOne('Apiv1\Repositories\Models\Asset', 'id', 'image_id');
    }

    public function channel()
    {
        return $this->belongsToMany('Apiv1\Repositories\Channels\Channel');
    }

    public function displayStyle()
    {
        return $this->belongsTo('Apiv1\Repositories\Models\DisplayStyle', 'display_style');
    }
}
