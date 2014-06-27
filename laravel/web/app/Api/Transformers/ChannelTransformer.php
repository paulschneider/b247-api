<?php namespace Api\Transformers;

use Api\Transformers\ArticleTransformer;

class ChannelTransformer extends Transformer {

    /**
    *
    * @var Api\Transformers\ArticleTransformer
    */
    protected $articleTransformer;

    public function __construct()
    {
        $this->articleTransformer = new ArticleTransformer;
    }

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
        $response = [
            'id' => $channel['id']
            ,'name' => $channel['name']
            ,'sefName' => $channel['sef_name']
            ,'colour' => $channel['colour']
            ,'secondaryColour' => $channel['secondary_colour']
            ,'path' => makePath( [ $channel['sef_name'] ] )
            ,'isEnabled' => isChannelUserEnabled( $channel['id'], $inactiveUserChannels )
        ];

        if( isset($channel['sub_channel']) and count($channel['sub_channel']) > 0 )
        {
            $subChannels = [];

            foreach( $channel['sub_channel'] AS $subChannel )
            {
                $pathToChannel = makePath( [ $channel['sef_name'], $subChannel['sef_name'] ] );

                $sub = [
                    'id' => $subChannel['id']
                    ,'name' => $subChannel['name']
                    ,'sefName' => $subChannel['sef_name']
                    ,'path' => $pathToChannel
                    ,'isEnabled' => isChannelUserEnabled( $subChannel['id'], $inactiveUserChannels )
                ];

                if( isset($subChannel['category']) and count($subChannel['category']) > 0 )
                {
                    $categories = [];

                    foreach( $subChannel['category'] AS $category )
                    {
                        $pathToCategory = makePath( [ $channel['sef_name'], $subChannel['sef_name'], $category['sef_name'] ] );

                        $cat = [
                            'id' => $category['id']
                            ,'name' => $category['name']
                            ,'sefName' => $category['sef_name']
                            ,'path' => $pathToCategory
                        ];

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
        return $this->articleTransformer->transformCollection($articles);
    }
}
