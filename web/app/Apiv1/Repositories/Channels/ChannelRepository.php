<?php namespace Apiv1\Repositories\Channels;

use Apiv1\Repositories\Channels\ChannelCategory;
use Apiv1\Repositories\Channels\Channel;
use Apiv1\Repositories\Sponsors\Sponsor;
use Apiv1\Repositories\Models\BaseModel;

Class ChannelRepository extends BaseModel {

    /**
    * return a list of all channels
    *
    * @var array
    */
    public function getAllChannels()
    {
        return Channel::with('subChannel.display')->active()->alive()->get()->toArray();
    }

    /**
    * return a list of channels with any sub_channels and sub_channels with any categories
    *
    * @var array
    */
    public function getChannels()
    {
        return Channel::with('subChannel.category', 'subChannel.display')->whereNull('parent_channel')->active()->alive()->get()->toArray();
    }

    /**
    * get a list of channels with any associated sub-channels
    *
    * @var array
    */
    public function getChannelList()
    {
        return Channel::with('subChannel.display')->get();
    }

    /**
    * get a list of categories assigned to a sub-channel
    *
    * @var array
    */
    public function getChannelCategories($channelId)
    {
        $result = Channel::with('category', 'parent')->where('id', $channelId)->get();

        sd('ChannelRepository::getChannelCategories()');
    }

    /**
    * get a specified channel and its relationships
    *
    * @var array
    */
    public function getChannel($identifier)
    {
        $query = Channel::with('category', 'display');

        if( is_numeric( $identifier ) )
        {
            $query->where('id', $identifier);
        }
        else
        {
            $query->where('sef_name', $identifier);
        }

        return $query->first();
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
    * get a list of sub-channels associated with a specified channel
    *
    * @var array
    */
    public function getChildren( $channelId )
    {
        $result = Channel::select('id')->where('parent_channel', $channelId)->get();

        $keys = [];

         $keys[] = $result->map(function($item) {
            return (int) $item->id;
        });

        return $keys[0]->toArray();
    }

    /**
    * get the basic details of a channel
    *
    * @var mixed
    */
    public function getSimpleChannel($channelId)
    {
        return Channel::whereId($channelId)->get()->first();
    }

    public function getChannelBySubChannel($channel)
    {
        return Channel::with('subChannel.category', 'subChannel.display')->where('id', $channel['parent_channel'])->first()->toArray();
    }

    /**
    * get a specified channel by a provided identifier. This is generic to cover off getting a channel or a sub-channel
    *
    * @var array
    */
    public function getChannelByIdentifier($identifier)
    {
        $query = Channel::with('subChannel.category', 'parent', 'category', 'display', 'subChannel.display');

        if( is_numeric($identifier) )
        {
            $query->where('id', $identifier);
        }
        else
        {
            $query->where('sef_name', $identifier);
        }

        $result = $query->get()->first();

        if( is_null($result) or $result->count() == 0)
        {
            return false;
        }

        return $result->toArray();
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
        $channel->display_type = $form['type'];
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