<?php

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
