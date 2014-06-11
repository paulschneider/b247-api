<?php namespace Version1\Channels;

use \Version1\Channels\ChannelInterface;
use \Version1\Channels\ChannelCategory;
use \Version1\Channels\Channel;
use \Version1\Sponsors\Sponsor;
use \Version1\Models\BaseModel;

Class ChannelRepository extends BaseModel implements ChannelInterface {

    /**
    * return a list of channels with any sub_channels and sub_channels with any categories
    *
    * @var array
    */
    public function getChannels()
    {
        return Channel::with('subChannel.category')->whereNull('parent_channel')->get()->toArray();
    }

    /**
    * get a list of channels with any associated sub-channels
    *
    * @var array
    */
    public function getChannelList()
    {
        return Channel::with('subChannel')->get();
    }

    public function getChannel($id)
    {
        return Channel::with('category', 'sponsors')->where('id', $id)->first();
    }

    /**
    * get an array of channels with ID's
    *
    * @var array
    */
    public function getSimpleChannels($channelId = null)
    {
        $channels = Channel::whereNull('parent_channel')->alive()->active()->lists('name', 'id');

        // if a channel ID has been provided then don't include it in the return
        unset($channels[$channelId]);

        return $channels;
    }

    /**
    * get a list channels that have parent channels
    *
    * @var array
    */
    public function getSimpleSubChannels()
    {
        return Channel::whereNotNull('parent_channel')->alive()->active()->lists('name', 'id');
    }

    /**
    * get channels by an identifier
    *
    * @var array
    */
    public function getChannelByIdentifier($identifier)
    {
        $query = Channel::with('subChannel.category', 'sponsors');

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
    public function storeChannel($form)
    {
        if( !empty($form['id']) )
        {
            $channel = Channel::find($form['id']);
        }
        else
        {
            $channel = new Channel();
        }

        $channel->name = $form['name'];
        $channel->sef_name = safename($form['name']);
        $channel->parent_channel = $form['parent_channel'] != 0 ? $form['parent_channel'] : null;
        $channel->colour = $form['colour'];
        $channel->secondary_colour = $form['sec_colour'];
        $channel->is_active = isset($form['is_active']) ? $form['is_active'] : false;

        \DB::table('channel_category')->where('channel_id', $channel->id)->delete();

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

            ChannelCategory::insert($data);
        }

        // save the channel to the database

        $channel->save();

        return $channel;
    }

}
