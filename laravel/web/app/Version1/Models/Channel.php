<?php namespace Version1\Models;

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
    * @var ???
    */
    public function category()
    {
        return $this->hasMany('\Version1\Models\ChannelCategory');
    }

    public function sponsors()
    {
        return $this->belongsToMany('\Version1\Models\Sponsor', 'sponsor_placement', 'content_id')->where('sponsor_placement.content_type', 1);
    }

    /**
    * create the relationship with sub_channels
    *
    * @var array
    */
    public function subChannel()
    {
        return $this->hasMany('\Version1\Models\SubChannel', 'parent_channel');
    }

    /**
    * return a list of channels with any sub_channels and sub_channels with any categories
    *
    * @var array
    */
    public static function getChannels()
    {
        return static::with('subChannel.category')->whereNull('parent_channel')->get()->toArray();
    }

    /**
    * get a list of channels with any associated sub-channels
    *
    * @var array
    */
    public static function getChannelList()
    {
        return static::with('subChannel')->get();
    }

    public static function getChannel($id)
    {
        return static::with('category', 'sponsors')->where('id', $id)->first();
    }

    /**
    * get an array of channels with ID's
    *
    * @var array
    */
    public static function getSimpleChannels($channelId = null)
    {
        $channels = static::whereNull('parent_channel')->alive()->active()->lists('name', 'id');

        // if a channel ID has been provided then don't include it in the return
        unset($channels[$channelId]);

        return $channels;
    }

    /**
    * get a list channels that have parent channels
    *
    * @var array
    */
    public static function getSimpleSubChannels()
    {
        return static::whereNotNull('parent_channel')->alive()->active()->lists('name', 'id');
    }

    /**
    * get channels by an identifier
    *
    * @var array
    */
    public static function getChannelByIdentifier($identifier)
    {
        $query = static::with('subChannel.category', 'sponsors');

        if( is_numeric($identifier) )
        {
            $query->where('id', $identifier);
        }
        else
        {
            $query->where('sef_name', $identifier);
        }

        $result = $query->get()->toArray();

        if( count($result) == 0)
        {
            return false;
        }

        return parent::dataCheck($result);
    }

    /**
    * store or update an existing channel
    *
    * @var array
    */
    public static function storeChannel($form)
    {
        if( !empty($form['id']) )
        {
            $channel = static::find($form['id']);
        }
        else
        {
            $channel = new \Version1\Models\Channel();
        }

        $channel->name = $form['name'];
        $channel->sef_name = safename($form['name']);
        $channel->parent_channel = $form['parent_channel'] != 0 ? $form['parent_channel'] : null;
        $channel->colour = $form['colour'];
        $channel->is_active = isset($form['is_active']) ? $form['is_active'] : false;

        if( isset($form['category']) and $form['id'] )
        {
            $data = [];

            foreach($form['category'] AS $cat)
            {
                $row = [
                    'channel_id' => $form['id']
                    ,'category_id' => $cat
                ];

                $data[] = $row;
            }

            \Version1\Models\ChannelCategory::insert($data);
        }

        // save the channel to the database

        $channel->save();

        // associate any sponsors with the channel
        \Version1\Models\Sponsor::assignChannelSponsors($channel, $form['sponsor']);

        return $channel;
    }
}
