<?php

namespace Version1\Controllers;

use Request;
use Response;
use Cache;
use Carbon\Carbon;

Class HomeController extends BaseController
{
    public function index()
    {
        if( Request::header('accessKey') )
        {
            $accessKey = Request::header('accessKey');

            if( ! $response = \Version1\Models\User::getUserChannels( $accessKey ) )
            {
                return HomeController::userNotFound( $accessKey );
            }
        }
        else
        {
            if( ! $response = cached("homepage") )
            {
                $response = \Version1\Models\Channel::getChannels();

                cacheIt("homepage", $response, "1 hour");
            }
        }

        return BaseController::respond($response, 200);
    }

    protected function userNotFound($accesskey)
    {
        $response = new \stdClass();

        $response->endpoint = Request::path();
        $response->message = "No channels were found for user with supplied accessKey.";
        $response->accessKey = $accesskey;
        $response->time = time();

        return BaseController::respond($response, 404);
    }

    public function missingMethod($parameters=array())
    {
        $response = new \stdClass();

        $response->endpoint = Request::path();
        $response->message = "Endpoint does not support method.";
        $response->unSupportedMethod = Request::method();
        $response->time = time();

        return BaseController::respond($response, 501);
    }
}
