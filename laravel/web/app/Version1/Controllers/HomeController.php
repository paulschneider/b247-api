<?php

namespace Version1\Controllers;

use Request;
use Response;
use Cache;
use Carbon\Carbon;

Class HomeController extends ApiController {

    /**
     *
     * @var Api\Transformers\ChannelTransformer
     */
     protected $channelTransformer;

    public function __construct(\Api\Transformers\ChannelTransformer $channelTransformer)
    {
        $this->channelTransformer = $channelTransformer;
    }

    public function index()
    {
        if( Request::header('accessKey') )
        {
            $accessKey = Request::header('accessKey');

            if( ! $response = $this->channelTransformer->transform(\Version1\Models\User::getUserChannels( $accessKey )) )
            {
                return $this->respondNotFound('No channels were found for user with supplied accessKey.');
            }
        }
        else
        {
            if( ! $response = cached("homepage") )
            {
                $response = $this->channelTransformer->transform(\Version1\Models\Channel::getChannels());

                cacheIt("homepage", $response, "1 hour");
            }
        }
        return $this->respond([
            'data' => $response
        ]);
    }
    public function missingMethod($parameters=array())
    {
        $this->setStatusCode(501)->respondWithError('Endpoint does not support method.');
    }
}
