<?php namespace Api\Transformers;

use \Api\Transformers\ArticleTransformer;

class ChannelTransformer extends Transformer {

    /**
    *
    * @var Api\Transformers\ArticleTransformer
    */
    protected $articleTransformer;

    public function __construct(ArticleTransformer $articleTransformer)
    {
        $this->articleTransformer = $articleTransformer;
    }

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection($data)
    {
        if( $data )
        {
            $response = new \stdClass();

            $items = [];

            if( isset($data['channels']) )
            {
                $channels = $data['channels'];

                unset($data['channels']);

                $response->user = $data;
            }
            else
            {
                $channels = $data;
            }

            if( is_array($channels) )
            {
                foreach( $channels AS $channel )
                {
                    $path = $channel['sef_name'].'/';

                    // create records foreach of the top level channels

                    $chan = array(
                        "id" => (int) $channel['id']
                        ,"name" => $channel['name']
                        ,"colour" => $channel['colour']
                        ,"secondaryColour" => $channel['secondary_colour']
                        ,"icon" => $channel['icon_img_id']
                    );

                    // only add the following attrs if the request came from a desktop client

                    if( isDesktop() )
                    {
                        $chan['sefName'] = $channel['sef_name'];
                        $chan['path'] = $path;
                    }

                    if( isset($channel['articles']) )
                    {
                        $chan['articles'] = $this->getArticles($channel['articles']);
                    }

                    $parentPath = $path;

                    // if there are sub-channels related to the parent channel then create records for each of those

                    if( isset($channel['sub_channel']) and count($channel['sub_channel']) > 0 )
                    {
                        $chan["subChannels"] = array();

                        foreach( $channel['sub_channel'] AS $subChannel )
                        {
                            // url path to the sub-channel

                            $path = $parentPath.$subChannel['sef_name'].'/';

                            $sub = array(
                                "id" => (int) $subChannel['id']
                                ,"name" => $subChannel['name']
                            );

                            // only add the following attrs if the request came from a desktop client

                            if( isDesktop() )
                            {
                                $sub['sefName'] = $subChannel['sef_name'];
                                $sub['path'] = $path;
                            }

                            $channelPath = $path;

                            // if there are categories related to the sub channel then go them and create records

                            if( isset($subChannel['category']) )
                            {
                                $sub["categories"] = array();

                                foreach( $subChannel['category'] AS $category )
                                {
                                    $path = $channelPath.$category['sef_name'].'/';

                                    $cat = array(
                                        "id" => (int) $category['id']
                                        ,"name" => $category['name']
                                    );

                                    // only add the following attrs if the request came from a desktop client

                                    if( isDesktop() )
                                    {
                                        $cat['sefName'] = $category['sef_name'];
                                        $cat['path'] = $path;
                                    }

                                    // add the new category record into the array for the sub-channel

                                    $sub['categories'][] = $cat;
                                }
                            }

                            // add the sub channel array into the array of sub-channels for this channel

                            $chan['subChannels'][] = $sub;
                        }
                    }

                    // add the channel array into the array of channels
                    $items[] = $chan;
                }
            }

            // return the cleaned item to the caller
            return $items;
        }
        else
        {
            return false;
        }
    }

    /**
     * Transform a single result into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transform($channel)
    {
        $response = [
            'id' => $channel['id']
            ,'name' => $channel['name']
            ,'sefName' => $channel['sef_name']
            ,'colour' => $channel['colour']
            ,'path' => $channel['sef_name'].'/'
        ];

        if( isset($channel['sub_channel']) and count($channel['sub_channel']) > 0 )
        {
            $subChannels = [];

            foreach( $channel['sub_channel'] AS $subChannel )
            {
                $pathToChannel = $response['path'].$subChannel['sef_name'].'/';

                $sub = [
                    'id' => $subChannel['id']
                    ,'name' => $subChannel['name']
                    ,'sefName' => $subChannel['sef_name']
                    ,'path' => $pathToChannel
                ];

                if( isset($subChannel['category']) and count($subChannel['category']) > 0 )
                {
                    $categories = [];

                    foreach( $subChannel['category'] AS $category )
                    {
                        $pathToCategory = $pathToChannel.$category['sef_name'];

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



    public function getArticles($articles)
    {
        return $this->articleTransformer->transformCollection($articles);
    }
}
