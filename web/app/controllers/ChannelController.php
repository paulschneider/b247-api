<?php

use Api\Transformers\ChannelTransformer;
use Api\Transformers\SubChannelTransformer;
use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;
use Api\Transformers\ListingTransformer;
use Api\Transformers\EventTransformer;

use Api\Factory\PatternMaker;
use Api\Factory\ChannelFeed;
use Api\Factory\PageMaker;
use Version1\Channels\Toolbox;

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
    * @var Api\Transformers\SubChannelTransformer
    */
    protected $subChannelTransformer;

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

    var $response;

    public function __construct(
        ChannelTransformer $channelTransformer
        , SubChannelTransformer $subChannelTransformer
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
        $this->subChannelTransformer = $subChannelTransformer;        
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
    public function show($identifier = null, $type = null)
    {
        if( is_null($identifier) )
        {
            return $this->respondWithInsufficientParameters();
        }

        if( ! $channel = $this->channelRepository->getChannelByIdentifier( $identifier ))
        {
            return $this->respondNoDataFound( Lang::get('api.channelNotFound') );
        }

        if( isSubChannel( $channel ) )
        {
            $response = $this->getSubChannel( $channel );
        }
        else
        {
            $response = $this->getChannel( $channel );
        }

        return $response;
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

        $allChannels = $this->channelRepository->getAllChannels();
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

        $this->channelFeed = new ChannelFeed($allChannels, $subChannels, $ads, [], true);

        if( ! $response = cached( $channelName ) )
        {
            $data = [
                'channel' => $this->channelTransformer->transform( $channel )
                ,'adverts' => $this->sponsorTransformer->transformCollection( $sponsors->toArray() )
                ,'features' => $this->articleTransformer->transformCollection( $this->articleRepository->getArticles( 'featured', 25 ), [ 'showBody' => false ] )
                ,'picks' => $picks
                ,'channelFeed' => $this->channelFeed->make()
            ];

            cacheIt( $channelName, $response, "1 hour" );
        }

        return $this->respondFound( Lang::get('api.channelFound'), $data );
    }

    /**
    * get the details of a sub-channel
    *
    * @return *
    */
    private function getSubChannel( $channel )
    {   
        $data = $this->channelRepository->getChannelBySubChannel($channel);

        $this->response = [
            'channel' => $this->channelTransformer->transform( Toolbox::filterSubChannels($data, $channel) )
            ,'adverts' => $this->sponsorTransformer->transformCollection( $this->sponsorRepository->getSponsors() )
        ];

        $type = $channel['display']['id'];

        switch( $type )
        {
            case Config::get('constants.displayType_article') :
                $result = $this->getChannelArticles( Config::get('constants.displayType_article'), $channel );
            break;
            case Config::get('constants.displayType_listing') :
                $result = $this->getChannelListing( $channel['id'], 'week', null, true );
            break;
            case Config::get('constants.displayType_directory') :
                $result = $this->getChannelArticles( Config::get('constants.displayType_directory'), $channel );
                $this->response['categories'] = Toolbox::getCategoryCount( $this->articleRepository->getChannelArticleCategory( $channel ) );
                unset($this->response['pagination']);
            break;
            case Config::get('constants.displayType_promotion') :                
                $result = $this->getChannelArticles( Config::get('constants.displayType_promotion'), $channel );
            break;
            default;
                $result = $this->getChannelArticles( Config::get('constants.displayType_article'), $channel );
            break;
        }

        if( isApiResponse($result) )
        {
            return $result;
        }

        return $this->respondFound( Lang::get('api.subChannelFound'), $this->response );
    }

    /**
    * return a list of articles for a given channel ( sub-channel )
    *
    * @return array
    */
    public function getChannelArticles($type, $channel )
    {
        // get some adverts from the database
        $sponsors = $this->sponsorRepository->getSponsors();

        // grab some articles regardless of type
        $articles = $this->articleRepository->getArticles( $type, 25, $channel['id'], true ); // ignore type, limit, channelId, isSubChannel

        $pagination = PageMaker::make($articles);       

        if ( count($pagination->items) > 0 )
        {
            // get some more adverts that aren't any of the ones retrieved above
            $ads = $this->sponsorRepository->getWhereNotInCollection( $sponsors, 30 );

            // create a new instance of the pattern maker
            $this->patternMaker = new PatternMaker(1, $pagination->meta->perPage);

            $this->response['articles'] = $this->patternMaker->make( [ 'articles' => $pagination->items, 'sponsors' => $ads ] )->articles;

            $this->response['pagination'] = $pagination->meta;

            return;
        }
        else
        {
            return $this->respondNoDataFound( Lang::get('api.noSubChannelArticles') );
        }
    }

    /**
    * return a listing for a given sub-channel
    *
    * @return array
    */
    public function getChannelListing($identifier, $duration, $dataReturn = false)
    {
        $articles = $this->articleRepository->getChannelListing( $identifier, 20, $duration, Input::get('time') );

        if( count( $articles ) > 0 )
        {
            $type = "picks";

            $result = Toolbox::extractHighlightedArticle($articles);
            $this->response['articles'] = $this->listingTransformer->transformCollection( $result->articles );
            $this->response['picks'] = $this->listingTransformer->transformCollection( $result->{$type} );   
        }
        else
        {
            return $this->respondNoDataFound(Lang::get('api.noArticlesForSpecifiedPeriod'));
        }

        // this was an internal call so just return the result set to the calling function
        if( $dataReturn )
        {
            exit('ChannelController::getChannelListing()');
            return;
        }
        // it was a direct external call so we need to send a full API response. Everything else is called from the getSubChannel() method above.
        else
        {
            if( ! $channel = $this->channelRepository->getChannelByIdentifier( $identifier ))
            {
                return $this->respondNoDataFound( Lang::get('api.channelNotFound') );
            }

            $data = $this->channelRepository->getChannelBySubChannel($channel);

            $type = "picks";
            $result = Toolbox::extractHighlightedArticle($articles);

            $response = [
                'channel' => $this->channelTransformer->transform( Toolbox::filterSubChannels($data, $channel) ),
                'adverts' => $this->sponsorTransformer->transformCollection( $this->sponsorRepository->getSponsors() ),                
            ];

            if( $duration == "week" )
            {
                $response['days'] = $this->listingTransformer->transformCollection( $articles, [ 'perDayLimit' => 3 ] );
            }
            else if( $duration == "day" )
            {                
                $response['days'] = $this->listingTransformer->transformCollection( $result->articles, [ 'picks' => $result->{$type} ] );
            }

            return $this->respondFound( Lang::get('api.subChannelFound'), $response );
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
