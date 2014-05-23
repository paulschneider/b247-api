<?php namespace Version1\Controllers;

use Request;
use Response;

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
       if( ! $response = cached("homepage") )
       {
            $data = [
                'channels' => $channels = $this->channelTransformer->transform(\Version1\Models\Channel::getChannels())
                ,'sponsors' => $this->sponsorTransformer->transform(\Version1\Models\Sponsor::getHomeSponsors())
                ,'featured' => $this->articleTransformer->transform(\Version1\Models\Article::getFeatured())
                ,'picks' => $this->articleTransformer->transform(\Version1\Models\Article::getPicks())
            ];

            cacheIt("homepage", $response, "1 hour");
       }

        return $this->respondFound('Homepage found', $data);
    }    

    /**
    * if a POST request is made
    *
    * @return Response
    */
    public function postIndex()
    {
        return $this->respondNotAllowed();
    }

    /**
    * if a PUT request is made
    *
    * @return Response
    */
    public function putIndex()
    {
        return $this->respondNotAllowed();
    }

    /**
    * if a PATCH request is made
    *
    * @return Response
    */
    public function patchIndex()
    {
        return $this->respondNotAllowed();
    }

    /**
    * if a DELETE request is made
    *
    * @return Response
    */
    public function deleteIndex()
    {
        return $this->respondNotAllowed();
    }
}
