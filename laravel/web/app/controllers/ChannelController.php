<?php

use Api\Transformers\ChannelTransformer;
use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;
use Api\Transformers\ListingTransformer;
use Api\Transformers\EventTransformer;

use Api\Factory\PatternMaker;
use Api\Factory\ChannelFeed;

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
    * @var Api\Factory\ChannelFeed
    */
    protected $channelFeed;

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
        , ChannelFeed $channelFeed

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
            return Api::respondWithInsufficientParameters();
        }

        if( ! $channel = $this->channelRepository->getChannelByIdentifier( $identifier ))
        {
            return Api::respondWithError("Channel does not exist.");
        }

        if( isSubChannel($channel) )
        {
            if ( ! $data = $this->getSubChannel( $channel ) )
            {
                return Api::respondWithError("There are not articles assigned to this sub-channel.");
            }
        }
        else
        {
            if( ! $data = $this->getChannel( $channel ) )
            {
                return Api::respondWithError("There are not articles assigned to this channel.");
            }
        }

        return Api::respondFound( 'Channel found', $data );
    }

    /**
    * get the details of a channel
    *
    * @return Response
    */
    private function getChannel($channel)
    {
        $channelId = $channel['id'];
        $channelName = $channel['sef_name'];

        $channels = $this->channelRepository->getAllChannels();
        $subChannels = $this->channelRepository->getChildren( $channelId );
        $sponsors = $this->sponsorRepository->getSponsors();

        // create a new instance of the pattern maker
        $this->patternMaker = new PatternMaker(1);

        // Picks
        $picks = $this->articleRepository->getArticles( 'picks', 25, $channelId );
        $ads = $this->sponsorRepository->getWhereNotInCollection( $sponsors, 30 );
        $response = $this->patternMaker->make( [ 'articles' => $picks, 'sponsors' => $ads ] );
        $picks = $response->articles;
        $ads = $response->sponsors;

        // create a new instance of the channel feed class and pass the required params to it

        $this->channelFeed = new ChannelFeed($channels, $subChannels, $ads);

        if( ! $response = cached( $channelName ) )
        {
            $data = [
                //'channels' => $this->channelTransformer->transformCollection( $channels )
                'adverts' => $this->sponsorTransformer->transformCollection( $sponsors->toArray() )
                ,'features' => $this->articleTransformer->transformCollection( $this->articleRepository->getArticles( 'featured', 25 ), [ 'showBody' => false] )
                ,'picks' => $picks
                ,'channelFeed' => $this->channelFeed->make()
            ];

            cacheIt( $channelName, $response, "1 hour" );
        }

        return $data;
    }

    /**
    * get the details of a sub-channel
    *
    * @return *
    */
    private function getSubChannel($channel)
    {
        $response = [
            'adverts' => $this->sponsorTransformer->transformCollection( $this->sponsorRepository->getSponsors() )
        ];

        $type = $channel['display']['id'];

        switch( $type )
        {
            case Config::get('constants.displayType_article') :
                $response['articles'] = $this->getChannelArticles( Config::get('constants.displayType_article'), $channel );
            break;
            case Config::get('constants.displayType_listing') :
                $response['listing'] = $this->getChannelListing( $channel['id'], 'week' );
            break;
            default;
                $response['articles'] = $this->getChannelArticles( Config::get('constants.displayType_article'), $channel );
            break;
        }

        return $response;
    }

    /**
    * return a list of articles for a given channel ( sub-channel )
    *
    * @return View
    */
    public function getChannelArticles($type = null, $channel )
    {
        // get some adverts from the database
        $sponsors = $this->sponsorRepository->getSponsors();

        // grab some articles regardless of type
        $articles = $this->articleRepository->getArticles( $type, 25, $channel['id'], true ); // ignore type, limit, channelId, isSubChannel

        if ( count($articles) > 0 )
        {
            // get some more adverts that aren't any of the ones retrieved above
            $ads = $this->sponsorRepository->getWhereNotInCollection( $sponsors, 30 );

            // create a new instance of the pattern maker
            $this->patternMaker = new PatternMaker(1);

            $articles = $this->patternMaker->make( [ 'articles' => $articles, 'sponsors' => $ads ] )->articles;

            return $articles;
        }
        else
        {
            return false;
        }
    }

    public function getChannelListing($identifier, $duration, $timestamp = null)
    {
        $response = [];

        $articles = $this->articleRepository->getChannelListing( $identifier, 20, $duration, $timestamp );

        if( $articles->count() > 0 )
        {
            return $response['days'] = $this->listingTransformer->transformCollection( $articles );
        }
        else
        {
            return false;
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
