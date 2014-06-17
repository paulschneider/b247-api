<?php

use Api\Transformers\ChannelTransformer;
use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;

use Version1\Events\EventRepository;
use Version1\Channels\ChannelRepository;
use Version1\Sponsors\SponsorRepository;
use Version1\Articles\ArticleRepository;

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

    public function __construct(
        ChannelTransformer $channelTransformer
        , ArticleTransformer $articleTransformer
        , SponsorTransformer $sponsorTransformer
        , EventRepository $eventRepository
        , ChannelRepository $channelRepository
        , SponsorRepository $sponsorRepository
        , ArticleRepository $articleRepository
    )
    {
        $this->channelTransformer = $channelTransformer;
        $this->articleTransformer = $articleTransformer;
        $this->sponsorTransformer = $sponsorTransformer;
        $this->eventRepository = $eventRepository;
        $this->channelRepository = $channelRepository;
        $this->sponsorRepository = $sponsorRepository;
        $this->articleRepository = $articleRepository;
    }

    public function index( $homePageChannelToShow = 48 )
    {
        $sponsors = $this->sponsorRepository->getSponsors();

        if( ! $response = cached("homepage") )
        {
            $data = [
                'channels' => $channels = $this->channelTransformer->transformCollection($this->channelRepository->getChannels())
                ,'adverts' => [
                    'home' => $this->sponsorTransformer->transformCollection($sponsors->toArray())
                    ,'picks' => $this->sponsorTransformer->transformCollection($this->sponsorRepository->getWhereNotInCollection( $sponsors ))
                ]
                ,'features' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'featured', 25 ))
                ,'picks' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'picks', 25 ))
                ,'channelFeed' => [
                    'channel' => $this->channelTransformer->transform($this->channelRepository->getSimpleChannel($homePageChannelToShow))
                    ,'whatsOn' => $this->articleTransformer->transformCollection($this->eventRepository->getEventsWithArticles($homePageChannelToShow, 20)) // get 20 articles from the whats on channel
                    ,'promos' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'promos', 20, $homePageChannelToShow ))
                    ,'directory' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'directory', 20, $homePageChannelToShow ))
                    ,'listing' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'listing', 20, $homePageChannelToShow ))
                ]
            ];

            cacheIt("homepage", $response, "1 hour");
        }

        return $this->respondFound('Homepage found', $data);
    }
}
