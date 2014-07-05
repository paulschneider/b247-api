<?php

Class HomeController extends ApiController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
    *  Main call to get the homepage response object
    */
    public function index()
    {
        $channels = $this->channelRepository->getChannels();
        $allChannels = $this->channelRepository->getAllChannels();
        $sponsors = $this->sponsorRepository->getSponsors();
        $inactiveUserChannels = [];

        // use the pattern maker, set the pattern we want to use
        $this->patternMaker->setPattern(1);

        $channelFeed = [];

        if( userIsAuthenticated() )
        {
            $inactiveUserChannels = $this->userRepository->getUserInactiveChannels( 1 );    
        }        

        // Picks
        $picks = $this->articleRepository->getArticles( 'picks', 25 );

        $ads = $this->sponsorRepository->getWhereNotInCollection( $sponsors, 30 );
        $response = $this->patternMaker->make( [ 'articles' => $picks, 'sponsors' => $ads ] );
        $picks = $response->articles;
        $ads = $response->sponsors;

        // Whats on
        $channel = 50;

        $whatsOn = $this->articleRepository->getArticlesWithEvents(null); // get 20 articles from the whats on channel
        $response = $this->patternMaker->make( [ 'articles' => $whatsOn, 'sponsors' => $ads ], "whats-on" );
        $whatsOn = $response->articles;

        $ads = $response->sponsors;

        $channel = $this->channelTransformer->transform( getChannel($channels, $channel) );
        $channel['articles'] = $whatsOn;

        $channelFeed[] = $channel;

        // create a new instance of the channel feed class and pass the required params to it

        $this->channelFeed = $this->createChannelFeed( $allChannels, [ 48, 49, 51, 52 ], $ads, $inactiveUserChannels );

        if( ! $response = cached("homepage") )
        {
            $data = [
                'channels' => $this->channelTransformer->transformCollection( $channels )
                ,'adverts' => $this->sponsorTransformer->transformCollection( $sponsors->toArray() )
                ,'features' => $this->articleTransformer->transformCollection( $this->articleRepository->getArticles( 'featured', 25 ), [ 'showBody' => false] )
                ,'picks' => $picks
                ,'channelFeed' => $this->channelFeed->make()
            ];

            cacheIt("homepage", $response, "1 hour");
        }

        return $this->respondFound(Lang::get('api.homepageFound'), $data);
    }
}
