<?php namespace Api\Transformers;

Class SubChannelTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $subChannels, $inactiveUserChannels = [] )
    {
        $response = [];

        foreach( $subChannels AS $channel )
        {
            $response[] = $this->transform( $channel, $inactiveUserChannels );
        }

        // return the cleaned item to the caller
        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transform( $channel, $inactiveUserChannels = [] )
    {
        $parent = $channel['parent'];

        $channelTransformer = \App::make('ChannelTransformer');
        $categoryTransformer = \App::make('CategoryTransformer');

        $response = [
            'id' => $channel['id']
            ,'name' => $channel['name']
            ,'sefName' => $channel['sef_name']
            ,'path' => makePath( [ $parent['sef_name'], $channel['sef_name'] ] )
            ,'isEnabled' => isChannelUserEnabled( $channel['id'], $inactiveUserChannels )
            ,'displayType' => [
                'id' => $channel['display']['id']
                ,'type' => $channel['display']['type']
            ]
            ,'parentChannel' => $channelTransformer->transform( $parent )
        ];

        if( isset( $channel['category'] ) )
        {
            foreach ($channel['category'] as $key => $category) 
            {
                $response['categories'][$key] = $categoryTransformer($category);
                $response['categories'][$key]['path'] = makePath( [ $parent['sef_name'], $channel['sef_name'], $category['sef_name'] ] )

                if( isMobile() )
                {
                    unset($response['categories'][$key]['sefName']);
                    unset($response['categories'][$key]['path']);
                }
            }
        }
        
        if( isMobile() )
        {
            unset($response['sefName']);
            unset($response['path']);
        }

        return $response;
    }
}