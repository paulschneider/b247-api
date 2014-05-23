<?php namespace Version1\Controllers;

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

     /**
      *
      * @var Api\Transformers\ArticleTransformer
      */
      protected $articleTransformer;

      /**
      *
      * @var Api\Transformers\SponsorTransformer
      */
      protected $sponsorTransformer;

    public function __construct(\Api\Transformers\ChannelTransformer $channelTransformer, \Api\Transformers\ArticleTransformer $articleTransformer, \Api\Transformers\SponsorTransformer $sponsorTransformer)
    {
        $this->channelTransformer = $channelTransformer;
        $this->articleTransformer = $articleTransformer;
        $this->sponsorTransformer = $sponsorTransformer;
    }

    public function index()
    {
        //return \Version1\Models\Sponsor::getHomeSponsors();

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
        //    if( ! $response = cached("homepage") )
        //    {
                $data = [
                    'channels' => $channels = $this->channelTransformer->transform(\Version1\Models\Channel::getChannels())
                    ,'sponsors' => $this->sponsorTransformer->transform(\Version1\Models\Sponsor::getHomeSponsors())
                    ,'featured' => $this->articleTransformer->transform(\Version1\Models\Article::getFeatured())
                    ,'picks' => $this->articleTransformer->transform(\Version1\Models\Article::getPicks())
                ];

                //cacheIt("homepage", $response, "1 hour");
        //    }
        }
        return $this->respondFound('Homepage found', $data);
    }

    /**
    * Coverall for any HTTP requests that are not covered by implemented methods
    *
    * @return Response
    */
    public function missingMethod($parameters=array())
    {
        $this->respondNotSupported('Endpoint does not support method.');
    }
}
