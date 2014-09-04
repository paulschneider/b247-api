<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

function getMessage($message)
{
    return Lang::get($message);
}

function clog($data)
{
    $logFile = 'console.log';

    $view_log = new Logger('View Logs');
    $view_log->pushHandler(new StreamHandler(storage_path().'/logs/'.$logFile, Logger::INFO));

    $view_log->addInfo($data);  
}

function anExternalUrl($string)
{
    $protocols = [ 'http://', 'https://' ];

    foreach($protocols AS $protocol)
    {
        if(strpos($string, $protocol) !== false)
        {
            return true;
        }
    }    
}

function getDay($dayNumber)
{
    $days = [
        0 => [ 'full' => 'Sunday', 'short' => 'Sun' ],
        1 => [ 'full' => 'Monday', 'short' => 'Mon' ],
        2 => [ 'full' => 'Tuesday', 'short' => 'Tue' ],
        3 => [ 'full' => 'Wednesday', 'short' => 'Wed' ],
        4 => [ 'full' => 'Thursday', 'short' => 'Thur' ],
        5 => [ 'full' => 'Friday', 'short' => 'Fri' ],
        6 => [ 'full' => 'Saturday', 'short' => 'Sat' ],
    ];

    return $days[$dayNumber];
}

function getMonth($monthNumber)
{
    $months = [
        0 => [ 'full' => 'January', 'short' => 'Jan' ],
        1 => [ 'full' => 'February', 'short' => 'Feb' ],
        2 => [ 'full' => 'March', 'short' => 'Mar' ],
        3 => [ 'full' => 'April', 'short' => 'Apr' ],
        4 => [ 'full' => 'May', 'short' => 'May' ],
        5 => [ 'full' => 'June', 'short' => 'Jun' ],
        6 => [ 'full' => 'July', 'short' => 'Jul' ],
        7 => [ 'full' => 'August', 'short' => 'Aug' ],
        8 => [ 'full' => 'September', 'short' => 'Sept' ],
        9 => [ 'full' => 'October', 'short' => 'Oct' ],
        10 => [ 'full' => 'November', 'short' => 'Nov' ],
        11 => [ 'full' => 'December', 'short' => 'Dec' ],
    ];

    return $months[$monthNumber];
}

// insert a new array item after a given associative array key
function insertInto($thisArray, $after, $withThisContent, $withThisArrayKey)
{
    if( array_key_exists($after, $thisArray) )
    {
        $keyAtPosition = array_search($after, array_keys($thisArray)); // the integer value of the array key

        $everythingAfterKeyAtPosition = array_splice($thisArray, $keyAtPosition+1, count($thisArray)); // splice off everything after the keyAtPosition value

        $thisArray[$withThisArrayKey] = $withThisContent; // the array item to be inserted

        return array_merge($thisArray, $everythingAfterKeyAtPosition); // merge and return the arrays
    }
    
    return false;
}

function dateFormat($date)
{
    return date('Y-m-d', strtotime($date));
}

function getDateTime()
{
    return date("Y-m-d H:i:s");   
}

// check an array to see if a required field is missing from a supplied list of required fields
function aRequiredParameterIsMissing($requiredFields, $form)
{
    foreach($requiredFields AS $field)
    {
        if( ! array_key_exists($field, $form) || empty($form[$field]))
        {
            return true;
        }
    }
}

function apiErrorResponse($response, $data = [])
{
    return App::make( 'ApiResponder' )
                ->setStatusCode(\Config::get("responsecodes.{$response}.code"))
                ->respondWithError(\Config::get("responsecodes.{$response}.message"), $data);
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

function isPromotionType($channel)
{
    $type = getSubChannelType($channel);
    
    return in_array($type, [
        Config::get('constants.displayType_promotion')
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

// more readable alias for userIsAuthenticated function
function userAccessKeyPresent()
{
    return userIsAuthenticated();
}

function userIsAuthenticated()
{
    if( array_key_exists('accessKey', getallheaders()) || Input::get('accessKey'))
    {
        return true;
    }

    return false;
}

function getAccessKey()
{
    if(Request::header("accessKey"))
    {
        return Request::header("accessKey");
    }
    elseif(Input::get('accessKey'))
    {
        return Input::get('accessKey');
    }
    else
    {
        return false;
    }
}

function isApiResponse($data)
{
    return $data instanceOf Illuminate\Http\JsonResponse ? true : false;
}

function makePath( $paths = [] )
{
    $str = "/channel/";

    foreach($paths AS $path)
    {
        $str .= trim($path).'/';
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
    if( Request::header('BristolAPIClient') == "iphone" || Request::header('BristolAPIClient') == "android")
    {
        return true;
    }
    else {
        return false;
    }
}

function isTablet()
{
    if( Request::header('BristolAPIClient') == "ipad")
    {
        return true;
    }
    else
    {
        return false;
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
