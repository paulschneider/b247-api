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
        return Channel::with('subChannel.category', 'subChannel.display')->whereNull('parent_channel')->active()->get()->toArray();
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
    }

    /**
    * get a specified channel and its relationships
    *
    * @var array
    */
    public function getChannel($identifier)
    {
        $query = Channel::with('category', 'display');

        if( is_numeric( $identifier ) ) {
            $query->where('id', $identifier);
        }
        else {
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

        # if an integer was passed through then grab the channel by its ID
        if( is_numeric($identifier) ) {
            $query->where('id', $identifier);
        }
         # then grab the channel by its sef_name field
        else {
            $query->where('sef_name', $identifier);
        }

        $result = $query->active()->get()->first();

        # if we didn't find anything then say so.
        if( ! $result) {
            return false;
        }

        # if there is a parent element and that parent channel is inactive then return 
        # nothing as the top level channel has been turned off
        if( isset($result->parent->id) && ! $result->parent->is_active ) {
            return false;
        }

        # finally, return an array representation of the channel
        return $result->toArray();
    }
}