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

	public static function getCategoryArticleCategories($list = [])
	{
		$sorted = [];

        foreach($list AS $item)
        {
            $categoryId = $item['categoryId'];

            if( ! array_key_exists( $categoryId, $sorted ) )
            {
                $sorted[$categoryId] = [
                    'id' => $categoryId,
                    'name' => $item['categoryName'],
                    'numberOfArticles' => 1                    
                ];

                if( isDesktop())
                {
                    $sorted[$categoryId]['path'] = makePath( [ $item['channelSefName'], $item['subChannelSefName'], $item['categorySefName'] ] );
                }
            }
            else
            {
                $sorted[$categoryId][ 'numberOfArticles' ]++;
            }
        }

        return array_values($sorted);
	}
}