<?php namespace Apiv1\Transformers;

use App;

class ChannelTransformer extends Transformer {

    /**
     * Authenticated user object (if auth'd)
     * 
     * @var Apiv1\Repositories\Users\User $user
     */
    private $user;

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $channels, $user )
    {
        # our main transformation response array
        $response = [];     

        foreach( $channels AS $channel )
        {
            $response[] = $this->transform( $channel, $user );
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
    public function transform( $channel, $user )
    { 
        # init an array where we can store any inactive channels the user may have opted out of
        $inactiveUserChannels = [];

        # initialise the category transformer
        $categoryTransformer = App::make('CategoryTransformer');

        # if we have a user object and there might be content we don't want to show, make that available to the class
        if( ! is_null($user) ) {
            # this could contain a list of channels the user has opted out of 
            $inactiveUserChannels = $user->inactive_channels;            
        }

        # create the content filer so we can work out what the user wants to see, if we have a user
        $contentFilter = App::make('Apiv1\Tools\ContentFilter')->setUser($user);        

        $response = [
            'id' => $channel['id'],
            'name' => $channel['name'],
            'description' => $channel['description'],
            'sefName' => $channel['sef_name'],
            'colour' => $channel['colour'],
            'secondaryColour' => $channel['secondary_colour'],
            'path' => makePath( [ $channel['sef_name'] ] ),
            'isEnabled' => isChannelUserEnabled( $channel['id'], $inactiveUserChannels ),
        ];

        // we use this transformer to transform the channelFeed as well. so this might be a sub-channel that contains parent data
        if( isset($channel['parent']) ) {
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
                    'description' => $subChannel['description'],
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
                        # create a web path for this category
                        $pathToCategory = makePath( [ $channel['sef_name'], $subChannel['sef_name'], $category['sef_name'] ] );

                        # user the category transformer to turn the category into the API response version
                        $cat = $categoryTransformer->transform($category);

                        # add the web path to the now transformed category array
                        $cat['path'] = $pathToCategory;

                        #work out whether the category is enabled within the user preferences
                        $cat['isEnabled'] = $contentFilter->isCategoryUserEnabled($category['id'], $subChannel['id']);

                        # and store it in the list of categories for this channel
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
}
