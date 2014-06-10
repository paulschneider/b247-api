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

    public function index()
    {
        if( ! $response = cached("homepage") )
        {
            $data = [
                'channels' => $channels = $this->channelTransformer->transformCollection($this->channelRepository->getChannels())
                ,'sponsors' => $this->sponsorTransformer->transform($this->sponsorRepository->getHomeSponsors())
                ,'featured' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'featured', 10 ))
                ,'picks' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'picks', 10 ))
                ,'whatsOn' => $this->articleTransformer->transformCollection($this->eventRepository->getEventsWithArticles('whats-on', 50))
            ];

            cacheIt("homepage", $response, "1 hour");
        }

        return $this->respondFound('Homepage found', $data);
    }
}
