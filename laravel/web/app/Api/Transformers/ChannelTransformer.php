<?php namespace Api\Transformers;

class ChannelTransformer extends Transformer {

    public function transform($data)
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
                        ,"icon" => $channel['icon_img_id']
                    );

                    // only add the following attrs if the request came from a desktop client

                    if( isDesktop() )
                    {
                        $chan['sefName'] = $channel['sef_name'];
                        $chan['path'] = $path;
                    }

                    $parentPath = $path;

                    // if there are sub-channels related to the parent channel then create records for each of those

                    if( isset($channel['sub_channel']) and count($channel['sub_channel']) > 0)
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
}