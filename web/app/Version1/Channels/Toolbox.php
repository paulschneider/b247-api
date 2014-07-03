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

	public static function getCategoryCount($list = [])
	{
		$sorted = [];

        foreach($list AS $item)
        {
            $categoryId = $item['category_id'];

            if( ! array_key_exists( $categoryId, $sorted ) )
            {
                $sorted[$categoryId] = [
                    'id' => $categoryId
                    ,'name' => $item['name']
                    ,'numberOfArticles' => 1
                ];
            }
            else
            {
                $sorted[$categoryId][ 'numberOfArticles' ]++;
            }
        }

        return array_values($sorted);
	}
}