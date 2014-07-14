<?php namespace Api\Transformers;

class ChannelTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $channels, $inactiveUserChannels = [] )
    {
        $response = [];

        foreach( $channels AS $channel )
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
        $categoryTransformer = \App::make('CategoryTransformer');

        $response = [
            'id' => $channel['id'],
            'name' => $channel['name'],
            'sefName' => $channel['sef_name'],
            'colour' => $channel['colour'],
            'secondaryColour' => $channel['secondary_colour'],
            'path' => makePath( [ $channel['sef_name'] ] ),
            'isEnabled' => isChannelUserEnabled( $channel['id'], $inactiveUserChannels ),
        ];

        // we use this transformer to transform the channelFeed as well. so this might be a sub-channel that contains parent data
        if( isset($channel['parent']) )
        {
            $response['path'] = makePath( [ $channel['parent']['sef_name'], $channel['sef_name'] ] );
        }

        if( isset($channel['sub_channel']) and count($channel['sub_channel']) > 0 )
        {
            $subChannels = [];

            foreach( $channel['sub_channel'] AS $subChannel )
            {
                $pathToChannel = makePath( [ $channel['sef_name'], $subChannel['sef_name'] ] );

                $sub = [
                    'id' => $subChannel['id'],
                    'name' => $subChannel['name'],
                    'sefName' => $subChannel['sef_name'],
                    'path' => $pathToChannel,
                    'displayType' => [
                        'id' => $subChannel['display']['id']
                        ,'type' => $subChannel['display']['type']
                    ],
                    'isEnabled' => isChannelUserEnabled( $subChannel['id'], $inactiveUserChannels ),
                ];

                if( isset($subChannel['category']) and count($subChannel['category']) > 0 )
                {
                    $categories = [];

                    foreach( $subChannel['category'] AS $category )
                    {
                        $pathToCategory = makePath( [ $channel['sef_name'], $subChannel['sef_name'], $category['sef_name'] ] );

                        $cat = $categoryTransformer->transform($category);

                        $cat['path'] = $pathToCategory;

                        $categories[] = $cat;
                    }

                    $sub['categories'] = $categories;
                }

                $subChannels[] = $sub;
            }

            $response['subChannels'] = $subChannels;
        }

        if( isMobile() )
        {
            unset($response['sefName']);
            unset($response['path']);
        }

        return $response;
    }

    public function getArticles( $articles , $options = [] )
    {
        $articleTransformer = \App::make('ArticleTransformer');
        return $articleTransformer->transformCollection($articles);
    }
}
