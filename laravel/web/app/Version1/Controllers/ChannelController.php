<?php namespace Version1\Controllers;

use View;
use Input;
use Redirect;
use \Api\Transformers\ChannelTransformer;
use \Api\Transformers\ArticleTransformer;
use \Api\Transformers\SponsorTransformer;

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

	public function __construct(ChannelTransformer $channelTransformer, ArticleTransformer $articleTransformer, SponsorTransformer $sponsorTransformer)
	{
		$this->channelTransformer = $channelTransformer;
		$this->articleTransformer = $articleTransformer;
		$this->sponsorTransformer = $sponsorTransformer;
	}

	public function index()
	{
		$channels = \Version1\Models\Channel::getChannelList();

		return View::make('channel.show', [ 'channels' => $channels ]);
	}

	/**
	* display a form to create a new channel
	*
	* @return View
	*/
	public function create()
	{
		$channels = \Version1\Models\Channel::getSimpleChannels();
		$sponsors = \Version1\Models\Sponsor::getSimpleSponsors();
		$channel = new \Version1\Models\Channel();

		return View::make('channel.create', [ 'channel' => $channel, 'channels' => $channels, 'sponsors' => $sponsors ]);
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
			$channel = \Version1\Models\Channel::getChannel($channelId);
		}
		else
		{
			return $this->respondNotValid('Invalid channel identifier supplied.');
		}

		$channels = \Version1\Models\Channel::getSimpleChannels($channel->id);
		$categories = \Version1\Models\Category::all();
		$sponsors = \Version1\Models\Sponsor::getSimpleSponsors();
		$channelCategory = array_flatten($channel->category->toArray());
		$channelSponsors = $channel->sponsors->lists('id');

		return View::make('channel.create', [ 'channel' => $channel, 'channels' => $channels, 'categories' => $categories, 'channelCategory' => $channelCategory, 'sponsors' => $sponsors, 'channelSponsors' => $channelSponsors ]);
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

		$channel = \Version1\Models\Channel::getChannelByIdentifier($identifier);

		$data = [
			'channel' => $this->channelTransformer->transform($channel)
			,'sponsors' => $this->sponsorTransformer->transformCollection($channel['sponsors'])
			,'featured' => $this->articleTransformer->transformCollection(\Version1\Models\Article::getArticles('featured', 8, $channel['id']))
			,'picked' => $this->articleTransformer->transformCollection(\Version1\Models\Article::getArticles('picks', 8, $channel['id']))
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
		if( ! $channel = \Version1\Models\Channel::storeChannel(Input::all()) )
		{
			return $this->respondNotValid($channel->errors);
		}
		else
		{
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
