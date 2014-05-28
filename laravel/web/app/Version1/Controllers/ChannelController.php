<?php namespace Version1\Controllers;

use View;
use Input;
use Redirect;
use \Api\Transformers\ChannelTransformer;

class ChannelController extends ApiController {

	/**
	*
	* @var Api\Transformers\ChannelTransformer
	*/
	protected $channelTransformer;

	public function __construct(ChannelTransformer $channelTransformer)
	{
		$this->channelTransformer = $channelTransformer;
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
		$channel = new \Version1\Models\Channel();
		return View::make('channel.create', [ 'channel' => $channel, 'channels' => $channels ]);
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
			$channel = \Version1\Models\Channel::with('category')->find($channelId);
		}
		else
		{
			return $this->respondNotValid('Invalid channel identifier supplied.');
		}

		$channels = \Version1\Models\Channel::getSimpleChannels($channel->id);
		$categories = \Version1\Models\Category::all();
		$channelCategory = array_flatten($channel->category->toArray());

		return View::make('channel.create', [ 'channel' => $channel, 'channels' => $channels, 'categories' => $categories, 'channelCategory' => $channelCategory ]);
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

		if(  is_numeric($identifier) )
		{
			return $this->channelTransformer->transform(\Version1\Models\Channel::getChannelById($identifier));
		}
		else
		{
			return $this->channelTransformer->transform(\Version1\Models\Channel::getChannelByName($identifier));
		}
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
