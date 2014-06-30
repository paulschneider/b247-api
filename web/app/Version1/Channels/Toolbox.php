<?php namespace Version1\Channels;

Class Toolbox {

	public static function filterSubChannels($channelList, $filterChannel)
	{
		foreach( $channelList['sub_channel'] AS $key => $channel )
		{
			if( $channel['id'] != $filterChannel['id'])
			{
				unset($channelList['sub_channel'][$key]);
			}
		}
		
		return $channelList;
	}
}