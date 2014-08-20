<?php namespace Apiv1\Transformers;

use App;
use Config;

class ChannelPreferencesTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $channels, $user )
    {
        $response = [];

        foreach($channels AS $channel)
        {
            $response[] = $this->transform($channel, $user);
        }

        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param sponsor
     * @return array
     */
    public function transform( $channel, $user )
    {   
        # create the content filer so we can work out what the user wants to see, if we have a user
        $contentFilter = App::make('Apiv1\Tools\ContentFilter')->setUser($user);  

        $response = [
            "id" => $channel['id'],
            "name" => $channel["name"],
            "isEnabled" => isChannelUserEnabled($channel['id'], $user->inactive_channels)
        ];

        if(isset($channel['sub_channel']))
        {
            foreach($channel['sub_channel'] AS $subChannel)
            {
                $tmpSubChannel = [
                    "id" => $subChannel['id'],
                    "name" => $subChannel["name"],
                    "isEnabled" => isChannelUserEnabled($subChannel['id'], $user->inactive_channels)
                ];

                if(isset($subChannel['category']))
                {
                    foreach($subChannel['category'] AS $category)
                    {
                        $tmpSubChannel['categories'][] = [
                            "id" => $category['id'],
                            "name" => $category["name"],
                            "isEnabled" => $contentFilter->isCategoryUserEnabled($category['id'], $subChannel['id'])
                        ];
                    }
                }

                $response['subChannels'][] = $tmpSubChannel;
            }
        }

        return $response;
    }
}
