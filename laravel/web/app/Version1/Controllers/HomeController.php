<?php

namespace Version1\Controllers;

use Request;
use Response;
use Cache;
use Carbon\Carbon;

Class HomeController extends BaseController
{
    public function getIndex()
    {
        if( Request::header('accessKey') )
        {
            $response = \Version1\Models\User::getUserChannels( Request::header('accessKey') );
        }
        else
        {
            if( ! $response = cached("homepage") )
            {
                $response = \Version1\Models\Channel::getChannels();

                cacheIt("homepage", $response, "1 hour");
            }
        }

        $response = Response::make(json_encode($response), 200);

        $response->header('Content-Type', 'application/json');

        return $response;
    }
}
