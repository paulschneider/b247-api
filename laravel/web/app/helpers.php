<?php

function getChannel( $channels, $channelId )
{
    if ( is_array($channels) )
    {
        foreach( $channels AS $channel )
        {
            if ( $channel['id'] == $channelId )
            {
                unset($channel['sub_channel']);
                unset($channel['display']);

                return $channel;
            }
        }
    }
    else
    {
        exit('no channels to sort. helpers.php :: getChannel()');
    }
}

// convert an epoch timestamp to a specified format
function convertTimestamp($format, $timestamp)
{
    return date($format, $timestamp);
}

function isSubChannel($channel)
{
    return empty($channel['parent_channel']) ? false : true;
}

function short_time($time)
{
    return date('H:i', strtotime($time));
}

// return a formatted array showing a sub-channel path via its parent
function makePathList($channels)
{
    $response = []; // temporary channel list

    foreach($channels AS $channel)
    {
        $path = $channel->name . ' / ';

        foreach($channel->sub_channel AS $sub)
        {
            $response[$sub->id] = $path.$sub->name;
        }
    }

    asort($response);

    return $response;
}

function getParentChannel($channels, $channel)
{
    return $channel->parent_channel != null ? $channels->find($channel->parent_channel)->name : '-';
}

function isMobile()
{
    // return true if client is mobile (obvs)
    return Agent::isMobile();
}

function isDesktop()
{
    // if its not mobile then its desktop
    if( ! Agent::isMobile() )
    {
        return true;
    }
}

function oracle($isFetaured)
{
    // the oracle always has the answer
    return $isFetaured ? 'Yes' : 'No';
}

function sourceClient()
{
    $response = [];

    if(Agent::isMobile())
    {
        $response['device'] = Agent::device();
    }
    else
    {
        $response['platform'] = Agent::platform();
    }

    $response['browser'] = Agent::browser();

    return $response;
}


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

function safeName($title, $separator = '-', $ascii_only = FALSE)
{
	if ($ascii_only === TRUE)
	{
		$title = preg_replace('![^'.preg_quote($separator).'a-z0-9\s]+!', '', strtolower($title));
	}
	else
	{
		$title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', strtolower($title));
		$title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);
	}

	return trim($title, $separator);
}

// shortcut for show_data function
function sd($data)
{
    echo "<pre>";
        print_r($data);
    echo "</pre>";
    exit;
}
