<?php

function cached($page)
{
    if( ! Cache::has($page) )
    {
        return false;
    }
    else
    {
        return Cache::get($page);
    }
}

function cacheIt($page, $data, $expiration)
{
    $carbon = new Carbon\Carbon;

    $expiry = $carbon::now()->addMinutes($expiration);

    Cache::add($page, $data, $expiry);
}

function clean($channels)
{
    $response = [];

    foreach( $channels AS $channel )
    {
        $path = $channel['sef_name'].'/';

        // create records foreach of the top level channels

        $chan = array(
            "id" => $channel['id']
            ,"icon" => $channel['icon_img_id']
            ,"name" => $channel['name']
            ,"sefName" => $channel['sef_name']
            ,"path" => $path
            ,"colour" => $channel['colour']
        );

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
                    "id" => $subChannel['id']
                    ,"icon" => $subChannel['icon_img_id']
                    ,"name" => $subChannel['name']
                    ,"sefName" => $subChannel['sef_name']
                    ,"path" => $path
                );

                $channelPath = $path;

                // if there are categories related to the sub channel then go them and create records

                if( isset($subChannel['channel_category']) and count($subChannel['channel_category']) > 0)
                {
                    $sub["categories"] = array();

                    foreach( $subChannel['channel_category'] AS $category )
                    {
                        $category = $category['category'];

                        $path = $channelPath.$category['sef_name'].'/';

                        $cat = array(
                            "id" => $category['id']
                            ,"icon" => $category['icon_img_id']
                            ,"name" => $category['name']
                            ,"sefName" => $category['sef_name']
                            ,"path" => $path
                        );

                        // add the new category record into the array for the sub-channel

                        $sub['categories'][] = $cat;
                    }
                }

                // add the sub channel array into the array of sub-channels for this channel

                $chan['subChannels'][] = $sub;
            }
        }

        // add the channel array into the array of channels

        $response[] = $chan;
    }

    // return the cleaned item to the caller

    return $response;
}
