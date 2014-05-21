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
