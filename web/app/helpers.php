<?php

function apiErrorResponse($response)
{
    return App::make( 'ApiResponder' )
                ->setStatusCode(\Config::get("responsecodes.{$response}.code"))
                ->respondWithError(\Config::get("responsecodes.{$response}.message"));
}

function apiSuccessResponse($response, $data)
{
    return App::make( 'ApiResponder' )
                ->setStatusCode(\Config::get("responsecodes.{$response}.code"))
                ->respondWithSuccess(\Config::get("responsecodes.{$response}.message"), $data);
}

function categoryBelongsToChannel( $channel, $category )
{
    if( isset($channel['subChannels']) )
    {
        if( isset( $channel['subChannels'][0]['categories'] ) ) 
        {
            $categories = $channel['subChannels'][0]['categories'];

            foreach( $categories AS $cat )
            {
                if( $cat['id'] == $category['id'] )
                {
                    return true;
                }
            }
        }
        else
        {
            return false;
        }        
    }
    else
    {
        if( empty($channel['category']) )
        {
            return false;
        }

        foreach( $channel['category'] AS $channelCat )
        {
            if( $channelCat['id'] == $category )
            {
                return true;
            }
        }    
    }

    return false;
}

function isArticleType($channel)
{
    $type = getSubChannelType($channel);
    
    return in_array($type, [
        Config::get('constants.displayType_article'),
        Config::get('constants.displayType_promotion'),
    ]) ? true : false;
}

function isDirectoryType($channel)
{
    $type = getSubChannelType($channel);
    
    return in_array($type, [
        Config::get('constants.displayType_directory')
    ]) ? true : false;
}

function isListingType($channel)
{
    $type = getSubChannelType($channel);
    
    return in_array($type, [
        Config::get('constants.displayType_listing')
    ]) ? true : false;
}

function getChannelId($article)
{
    return $article['location'][0]['channelId'];
}

function getSubChannelType($channel)
{    
    return $channel['subChannels'][0]['displayType']['id'];
}

function getChannelType($channel)
{
    return $channel['subChannels'][0]['displayType']['type'];
}

function getSubChannelId($channel)
{
    return $channel['subChannels'][0]['id'];
}

function userIsAuthenticated()
{
    if( Request::header("accessKey") )
    {
        return true;
    }

    return false;
}

function isApiResponse($data)
{
    return $data instanceOf Illuminate\Http\JsonResponse ? true : false;
}

function makePath( $paths = [] )
{
    $str = "/";
    foreach($paths AS $path)
    {
        $str .= $path.'/';
    }

    return $str;
}

function isChannelUserEnabled($channelId, $inactiveUserChannels)
{
    return in_array($channelId, $inactiveUserChannels) ? false : true;
}

function getChannel( $channels, $channelId )
{ 
    if ( is_array($channels) )
    {
        foreach( $channels AS $channel )
        {
            if ( $channel['id'] == $channelId )
            {
                if( ! empty($channel['parent_channel']) )
                {
                    $channel['parent'] = getChannel( $channels, $channel['parent_channel'] );
                }

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

function aSubChannel($channel)
{
    return ! empty($channel['parent_channel']) ? true : false;
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
    // check for the existence of the header param
    if( Request::header('BristolAPIClient') )
    {
        return true;
    }
}

function isDesktop()
{
    // if its not mobile then its desktop
    // check for the existence of the header param
    if( ! Request::header('BristolAPIClient') )
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
