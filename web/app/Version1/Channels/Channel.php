<?php namespace Version1\Channels;

use Version1\Sponsors\Sponsor;
use Version1\Channels\SubChannel;
use Version1\Models\BaseModel;
use Version1\Channels\ChannelCategory;

Class Channel extends BaseModel {

    protected $table = 'channel';

    protected $fillable = [ 'icon_img_id', 'name', 'sef_name', 'colour', 'created_at', 'updated_at' ];

    protected $hidden = [ 'is_active', 'is_deleted', 'created_at', 'updated_at', 'content_type' ];

    /**
    * Form validation rules for a new channel
    *
    * @var array
    */
    protected static $rules = [

        'name' => 'required'

    ];

    /**
    * create the relationship with channel_category
    *
    * @var array
    */
    public function category()
    {
       return $this->belongsToMany('Version1\Categories\Category', 'channel_category', 'channel_id');
    }

    /**
    * create the relationship with sponsors
    *
    * @var array
    */
    public function sponsors()
    {
        return $this->belongsToMany('Version1\Sponsors\Sponsor', 'sponsor_placement', 'content_id')->where('sponsor_placement.content_type', 1);
    }

    /**
    * create the relationship with sub_channels
    *
    * @var array
    */
    public function subChannel()
    {
        return $this->hasMany('Version1\Channels\SubChannel', 'parent_channel');
    }

    public function parent()
    {
        return $this->belongsTo('\Version1\Channels\Channel', 'parent_channel');
    }

    /**
    * create the relationship with display_type
    *
    * @var array
    */
    public function display()
    {
        return $this->belongsTo('\Version1\Models\DisplayType', 'display_type');
    }
}
