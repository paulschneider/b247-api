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

    public function subChannel()
    {
        return $this->hasMany('\Version1\Models\SubChannel', 'parent_channel');
    }

    public static function getChannels()
    {
        return static::with('subChannel.category')->whereNull('parent_channel')->get()->toArray();
    }

    public static function getChannelList()
    {
        return static::with('subChannel')->get();
    }

    public static function getSimpleChannels($channelId = null)
    {
        $channels = static::whereNull('parent_channel')->alive()->active()->lists('name', 'id');

        // if a channel ID has been provided then don't include it in the return
        unset($channels[$channelId]);

        return $channels;
    }

    public static function getSimpleSubChannels()
    {
        return static::whereNotNull('parent_channel')->alive()->active()->lists('name', 'id');
    }

    public static function getChannelById($id)
    {
        return parent::dataCheck(static::with('subChannel.category')->whereId($id)->get());
    }

    public static function getChannelByName($name)
    {
        return parent::dataCheck(static::with('subChannel.category')->whereSefName($name)->get());
    }

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
        $channel->is_active = $form['is_active'];

        if( $form['category'] and $form['id'] )
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

        $channel->save();

        return $channel;
    }
}
