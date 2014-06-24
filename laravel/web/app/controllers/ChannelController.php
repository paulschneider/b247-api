<?php

use Api\Transformers\ChannelTransformer;
use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;
use Api\Transformers\ListingTransformer;
use Api\Transformers\EventTransformer;

use Api\Factory\PatternMaker;

use Version1\Events\EventRepository;
use Version1\Articles\ArticleRepository;
use Version1\Channels\ChannelRepository;

use Version1\Sponsors\SponsorRepository;
use Version1\Categories\CategoryRepository;

use Version1\Models\DisplayType;
use Version1\Channels\Channel;

class ChannelController extends ApiController {

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
    * @var Api\Transformers\ListingTransformer
    */
    protected $listingTransformer;

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
    * @var Version1\Categories\CategoryRepository
    */
    protected $categoryRepository;

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
        , ListingTransformer $listingTransformer
        , EventTransformer $eventTransformer
        , PatternMaker $patternMaker

        , EventRepository $eventRepository
        , ChannelRepository $channelRepository
        , CategoryRepository $categoryRepository
        , SponsorRepository $sponsorRepository
        , ArticleRepository $articleRepository
    )
    {
        $this->channelTransformer = $channelTransformer;
        $this->articleTransformer = $articleTransformer;
        $this->sponsorTransformer = $sponsorTransformer;
        $this->listingTransformer = $listingTransformer;
        $this->eventTransformer = $eventTransformer;
        $this->eventRepository = $eventRepository;
        $this->channelRepository = $channelRepository;
        $this->categoryRepository = $categoryRepository;
        $this->sponsorRepository = $sponsorRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
    * display a html list of channels
    *
    * @return View
    */
    public function index()
    {
        $channels = $this->channelRepository->getChannelList();

        return View::make('channel.show', compact('channels'));
    }

    /**
    * display a form to create a new channel
    *
    * @return View
    */
    public function create()
    {
        $channels = $this->channelRepository->getSimpleChannels();
        $sponsors = $this->sponsorRepository->getSimpleSponsors();
        $types = DisplayType::getSimpleDisplayTypes();
        $channel = new Channel();

        return View::make('channel.create', compact('channel', 'channels', 'sponsors', 'types'));
    }

    /**
    * display a form to edit an existing channel
    *
    * @return View
    */
    public function edit($channelId = null)
    {
        if( is_numeric($channelId) )
        {
            $channel = $this->channelRepository->getChannel($channelId);
        }
        else
        {
            return $this->respondNotValid('Invalid channel identifier supplied.');
        }

        $channels = $this->channelRepository->getSimpleChannels($channel->id);
        $categories = $this->categoryRepository->getAll();
        $sponsors = $this->sponsorRepository->getSimpleSponsors();
        $channelCategory = array_flatten($channel->category->toArray());
        $channelSponsors = $channel->sponsors->lists('id');
        $types = DisplayType::getSimpleDisplayTypes();

        return View::make('channel.create', compact('channel', 'channels', 'sponsors', 'channelCategory', 'channelSponsors', 'categories', 'types'));
    }

    /**
    * display a list of existing channels
    *
    * @return View
    */
    public function show($identifier = null)
    {
        if( is_null($identifier) )
        {
            return $this->respondWithInsufficientParameters();
        }

        if( ! $channel = $this->channelRepository->getChannelByIdentifier($identifier))
        {
            return $this->respondNoDataFound();
        }

        if( isSuBChannel($channel) )
        {
            $data = $this->getSubChannel($channel);
        }
        else
        {
            $data = $this->getChannel($channel);
        }

        return $this->respondFound('Channel found', $data);
    }

    /**
    * return a list of articles for a given channel ( sub-channel )
    *
    * @return View
    */
    public function getChannelArticles($type = null, $identifier = null)
    {
        // make sure we have an ID to work with

        if( is_null( $identifier ) )
        {
            return $this->respondWithInsufficientParameters();
        }

        // grab the channel

        $channel = $this->channelRepository->getChannel($identifier);

        // check to make sure the channel Id provided is a sub-channel

        if( is_null( $channel['parent_channel'] ) )
        {
            return $this->respondWithError("Channel is not a sub-channel. Nothing to do.");
        }

        // get some adverts from the database
        $sponsors = $this->sponsorRepository->getSponsors();

        // grab some articles regardless of type
        $articles = $this->articleRepository->getArticles( $type, 25, $channel['id'], true ); // ignore type, limit, channelId, isSubChannel

        // get some more adverts that aren't any of the ones retrieved above
        $ads = $this->sponsorRepository->getWhereNotInCollection( $sponsors, 30 );

        // create a new instance of the pattern maker
        $this->patternMaker = new PatternMaker(1);

        // create out response array

        $data = [
            'channel' => $this->channelTransformer->transform( $channel )
            ,'adverts' => $this->sponsorTransformer->transformCollection( $sponsors )
            ,$type.'s' => $this->patternMaker->make( [ 'sponsor' => $this->sponsorTransformer, 'article' => $this->articleTransformer ] , [ 'articles' => $articles, 'sponsors' => $ads ] )
        ];

        // and return it

        return $this->respondFound('Channel found', $data);
    }

    /**
    * get the details of a channel
    *
    * @return Response
    */
    private function getChannel($channel)
    {
        $channelId = $channel['id'];

        $sponsors = $this->sponsorRepository->getSponsors();
        $articles = $this->articleRepository->getArticles( 'picks', 25, $channelId );
        $ads = $this->sponsorRepository->getWhereNotInCollection( $sponsors, 30 );

        // create a new instance of the pattern maker
        $this->patternMaker = new PatternMaker(1);

        return [
            'channels' => $this->channelTransformer->transformCollection( $this->channelRepository->getChannels() )
            ,'adverts' => $this->sponsorTransformer->transformCollection( $sponsors->toArray() )
            ,'features' => $this->articleTransformer->transformCollection( $this->articleRepository->getArticles( 'featured', 25, $channelId ), [ 'showBody' => false] )
            ,'picks' => $this->patternMaker->make( [ 'sponsor' => $this->sponsorTransformer, 'article' => $this->articleTransformer ] , [ 'articles' => $articles, 'sponsors' => $ads ] )
            ,'channelFeed' => [
                'channel' => $this->channelTransformer->transform($this->channelRepository->getSimpleChannel($channelId))
                ,'whatsOn' => $this->articleTransformer->transformCollection($this->eventRepository->getEventsWithArticles($channelId, 20), [ 'showBody' => false] ) // get 20 articles from the whats on channel
                ,'promos' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'promotion', 20, $channelId ), [ 'showBody' => false] )
                ,'directory' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'directory', 20, $channelId ), [ 'showBody' => false] )
                ,'listing' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'listing', 20, $channelId ), [ 'showBody' => false] )
            ]
            ,'subChannels' => $this->articleRepository->getArticlesBySubChannel(20, $channel['id'], $this->articleTransformer)
        ];
    }

    /**
    * get the details of a sub-channel
    *
    * @return *
    */
    private function getSubChannel($channel)
    {
        return [
            'articles' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles(null, 20, $channel['id'], true)) // ( type, limit, channelId, subChannel = true )
            ,'adverts' => $this->sponsorTransformer->transformCollection($channel['sponsors'])
        ];
    }

    public function listing($identifier, $duration = null, $timestamp = null)
    {
        if( is_null($duration) or is_null($timestamp) )
        {
            return $this->respondWithInsufficientParameters();
        }

        if( ! $channel = $this->channelRepository->getChannelByIdentifier($identifier))
        {
            return $this->respondNoDataFound();
        }

        if( ! isSubChannel($channel) )
        {
            return $this->respondWithError("Channel is not a sub-channel. Nothing to do");
        }

        $articles = $this->articleRepository->getChannelListing( $channel['id'], 20, $duration, $timestamp );

        if( $articles->count() > 0 )
        {
            $data = [
                'adverts' => $this->sponsorTransformer->transformCollection($channel['sponsors'])
                ,'days' => $this->listingTransformer->transformCollection( $articles, [ 'articleTransformer' => $this->articleTransformer, 'eventTransformer' => $this->eventTransformer ] )
            ];

            return $this->respondFound('Listings found', $data);
        }
        else
        {
            return $this->respondWithError('There are no articles to return');
        }

    }

    /**
    * store the details of a new channel
    *
    * @return Redirect
    */
    public function store()
    {
        if( ! $channel = $this->channelRepository->storeChannel(Input::all()) )
        {
            return $this->respondNotValid($channel->errors);
        }
        else
        {
            // associate any sponsors with the channel
            $this->sponsorRepository->assignChannelSponsors($channel, Input::get('sponsor'));

            return Redirect::to('channel');
        }
    }

    /**
    * action on an UPDATE call to the resource
    *
    * @return ApiController Response
    */
    public function update()
    {
        return ApiController::respondNotAllowed();
    }

    /**
    * action on an UPDATE call to the resource
    *
    * @return ApiController Response
    */
    public function destroy()
    {
        return ApiController::respondNotAllowed();
    }
}
