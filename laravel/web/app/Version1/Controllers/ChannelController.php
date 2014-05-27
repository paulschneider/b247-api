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

	public function index($identifier)
	{
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
	* display a form to create a new channel
	*
	* @return View
	*/
	public function create($channelId = null)
	{
		if( ! is_null($channelId) )
		{
			$channel = \Version1\Models\Channel::with('category')->find($channelId);
		}
		else
		{
			$channel = new \Version1\Models\Channel();
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
	public function show()
	{
		$channels = \Version1\Models\Channel::getChannelList();

		return View::make('channel.show', [ 'channels' => $channels ]);
	}

	/**
	* if a GET request is made without the required identifier
	*
	* @return Response
	*/
	public function getIndex()
	{
		return $this->respondWithInsufficientParameters('Not enough arguements to complete request.');
	}

	/**
	* if a POST request is made
	*
	* @return Response
	*/
	// public function postIndex()
	// {
	// 	return $this->respondNotAllowed();
	// }

	/**
	* store the details of a new channel
	*
	* @return Redirect
	*/
	public function store()
	{
		if( ! $article = \Version1\Models\Channel::storeChannel(Input::all()) )
		{
			return $this->respondNotValid($channel->errors);
		}
		else
		{
			return Redirect::to('channel/list');
		}
	}

	/**
	* if a PUT request is made
	*
	* @return Response
	*/
	public function putIndex()
	{
		return $this->respondNotAllowed();
	}

	/**
	* if a PATCH request is made
	*
	* @return Response
	*/
	public function patchIndex()
	{
		return $this->respondNotAllowed();
	}

	/**
	* if a DELETE request is made
	*
	* @return Response
	*/
	public function deleteIndex()
	{
		return $this->respondNotAllowed();
	}
}
