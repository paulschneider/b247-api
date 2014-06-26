<?php

use Api\Transformers\ChannelTransformer;
use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;
use Api\Transformers\EventTransformer;

use Api\Factory\PatternMaker;
use Api\Factory\ChannelFeed;

use Version1\Events\EventRepository;
use Version1\Channels\ChannelRepository;
use Version1\Sponsors\SponsorRepository;
use Version1\Articles\ArticleRepository;
use Version1\Users\UserRepository;

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

    /**
    *
    * @var Api\Transformers\EventTransformer
    */
    protected $eventTransformer;

    /**
    *
    * @var Api\Factory\PatternMaker
    */
    protected $patternMaker;

    /**
    *
    * @var Api\Events\EventRepository
    */
    protected $eventRepository;

    /**
    *
    * @var Version1\Channels\ChannelRepository
    */
    protected $channelRepository;

    /**
    *
    * @var Version1\Sponsor\SponsorRepository
    */
    protected $sponsorRepository;

    /**
    *
    * @var Version1\Articles\ArticleRepository
    */
    protected $articleRepository;

    /**
    *
    * @var Version1\Users\UserRepository
    */
    protected $userRepository;

    public function __construct(
        ChannelTransformer $channelTransformer
        , ArticleTransformer $articleTransformer
        , SponsorTransformer $sponsorTransformer
        , EventTransformer $eventTransformer
        , PatternMaker $patternMaker
        , EventRepository $eventRepository
        , ChannelRepository $channelRepository
        , SponsorRepository $sponsorRepository
        , ArticleRepository $articleRepository
        , UserRepository $userRepository
    )
    {
        $this->channelTransformer = $channelTransformer;
        $this->articleTransformer = $articleTransformer;
        $this->sponsorTransformer = $sponsorTransformer;
        $this->eventTransformer = $eventTransformer;
        $this->eventRepository = $eventRepository;
        $this->channelRepository = $channelRepository;
        $this->sponsorRepository = $sponsorRepository;
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $channels = $this->channelRepository->getChannels();
        $allChannels = $this->channelRepository->getAllChannels();
        $sponsors = $this->sponsorRepository->getSponsors();
        $inactiveUserChannels = [];

        // create a new instance of the pattern maker
        $this->patternMaker = new PatternMaker(1);

        $channelFeed = [];

        // if( $this->userIsAuthenticated() )
        // {
            $inactiveUserChannels = $this->userRepository->getUserInactiveChannels( 1 );    
        //}        

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

        $this->channelFeed = new ChannelFeed( $allChannels, [ 48, 49, 51, 52 ], $ads, $inactiveUserChannels );

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

        return $this->respondFound('Homepage found', $data);
    }
}
