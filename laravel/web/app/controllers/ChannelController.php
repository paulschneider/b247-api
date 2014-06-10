<?php

use Api\Transformers\ChannelTransformer;
use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;
use Version1\Articles\ArticleRepository;
use Version1\Channels\ChannelRepository;
use Version1\Channels\Channel;
use Version1\Sponsors\SponsorRepository;
use Version1\Categories\categoryRepository;

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
        , ChannelRepository $channelRepository
        , CategoryRepository $categoryRepository
        , SponsorRepository $sponsorRepository
        , ArticleRepository $articleRepository
    )
    {
        $this->channelTransformer = $channelTransformer;
        $this->articleTransformer = $articleTransformer;
        $this->sponsorTransformer = $sponsorTransformer;
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

        if( ! $channel = Channel::getChannelByIdentifier($identifier))
        {
            return $this->respondNoDataFound();
        }

        $data = [
            'channel' => $this->channelTransformer->transform($channel)
            ,'sponsors' => $this->sponsorTransformer->transformCollection($channel['sponsors'])
            ,'featured' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles('featured', 8, $channel['id']))
            ,'picked' => $this->articleTransformer->transformCollection($this->articleRepository->getArticles('picks', 8, $channel['id']))
            ,'highlights' => $this->channelTransformer->transformCollection($this->articleRepository->getWithArticles($channel['id']))
        ];

        return $this->respondFound('Channel found', $data);
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
