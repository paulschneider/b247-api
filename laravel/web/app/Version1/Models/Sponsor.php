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
        return $this->belongsToMany('\Version1\Models\Channel', 'sponsor_placement', 'sponsor_id', 'id');
    }

    /**
    * get a non-specific list of sponsors for the homepage
    *
    * @return array
    */
    public static function getHomeSponsors()
    {
        return static::with('asset')->alive()->take(3)->get()->toArray();
    }

    /**
    * get a full list of sponsor records
    *
    * @return array
    */
    public static function getAscendingList()
    {
        return static::createdDescending()->get();
    }

    public static function getSimpleSponsors()
    {
        return static::active()->alive()->createdDescending()->lists('title', 'id');
    }

    /**
    * create or update a sponsor record
    *
    * @return Sponsor
    */
    public static function storeSponsor($form)
    {
        if( !empty($form['id']) )
        {
            $sponsor = static::find($form['id']);
        }
        else
        {
            $sponsor = new Sponsor();
        }

        $sponsor->title = $form['title'];
        $sponsor->url = $form['url'];
        $sponsor->is_active = isset($form['is_active']) ? $form['is_active'] : false;

        $sponsor->save();

        return $sponsor;
    }

    public static function assignChannelSponsors(\Version1\Models\Channel $channel, $sponsors)
    {
        // 1 - content_type::type = channel

        return \Version1\Models\SponsorPlacement::place(1, $channel->id, $sponsors);
    }
}
