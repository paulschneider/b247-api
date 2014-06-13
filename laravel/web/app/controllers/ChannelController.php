<?php

use Api\Transformers\ChannelTransformer;
use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;
use Api\Transformers\ListingTransformer;
use Version1\Articles\ArticleRepository;
use Version1\Channels\ChannelRepository;
use Version1\Channels\Channel;
use Version1\Sponsors\SponsorRepository;
use Version1\Categories\CategoryRepository;

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
        $this->channelRepository = $channelRepository;
        $this->categoryRepository = $categoryRepository;
        $this->sponsorRepository = $sponsorRepository;
        $this->articleRepository = $articleRepository;
    }

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
        $channel = new Channel();

        return View::make('channel.create', compact('channel', 'channels', 'sponsors'));
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

        return View::make('channel.create', compact('channel', 'channels', 'sponsors', 'channelCategory', 'channelSponsors', 'categories'));
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
    * get the details of a channel
    *
    * @return Response
    */
    private function getChannel($channel)
    {
        return [
            'channel' => $this->channelTransformer->transform($channel)
            ,'adverts' => $this->sponsorTransformer->transformCollection($channel['sponsors'])
            ,'featured' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles('featured', 5, $channel['id']))
            ,'picked' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles('picks', 20, $channel['id']))
            ,'subChannels' => $this->articleRepository->getArticlesBySubChannel(20, $channel['id'], $this->articleTransformer)
            ,'promos' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles( 'promos', 20, $channel['id'] ))
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

    public function listing($identifier)
    {
        if( ! $channel = $this->channelRepository->getChannelByIdentifier($identifier))
        {
            return $this->respondNoDataFound();
        }

        if( ! isSuBChannel($channel) )
        {
            return $this->respondWithError("Supplied channel identifier is not a sub-channel");
        }

        $data = [
            'days' => $this->articleRepository->getChannelArticlesbyDate($channel['id'], 20, $this->listingTransformer, $this->articleTransformer)
            ,'adverts' => $this->sponsorTransformer->transformCollection($channel['sponsors'])
        ];

        return $data;
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
