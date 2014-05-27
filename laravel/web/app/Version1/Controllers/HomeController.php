<?php namespace Version1\Controllers;

use Request;
use Response;
use \Api\Transformers\ChannelTransformer;
use \Api\Transformers\ArticleTransformer;
use \Api\Transformers\SponsorTransformer;

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

    public function __construct(ChannelTransformer $channelTransformer, ArticleTransformer $articleTransformer, SponsorTransformer $sponsorTransformer)
    {
        $this->channelTransformer = $channelTransformer;
        $this->articleTransformer = $articleTransformer;
        $this->sponsorTransformer = $sponsorTransformer;
    }

    public function index()
    {
    //    if( ! $response = cached("homepage") )
    //    {
            $data = [
                'channels' => $channels = $this->channelTransformer->transformCollection(\Version1\Models\Channel::getChannels())
                ,'sponsors' => $this->sponsorTransformer->transform(\Version1\Models\Sponsor::getHomeSponsors())
                ,'featured' => $this->articleTransformer->transformCollection(\Version1\Models\Article::getArticles( 'featured', 10 ))
                ,'picks' => $this->articleTransformer->transformCollection(\Version1\Models\Article::getArticles( 'picks', 10 ))
            ];
       //
    //         cacheIt("homepage", $response, "1 hour");
    //    }

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
