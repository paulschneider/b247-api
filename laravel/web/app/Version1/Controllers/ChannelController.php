<?php namespace Version1\Controllers;

class ChannelController extends ApiController {

	/**
	*
	* @var Api\Transformers\ChannelTransformer
	*/
	protected $channelTransformer;

	public function __construct(\Api\Transformers\ChannelTransformer $channelTransformer)
	{
		$this->channelTransformer = $channelTransformer;
	}

	public function index($id)
	{
		return $this->channelTransformer->transform(\Version1\Models\Channel::getChannel($id));
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
	public function postIndex()
	{
		return $this->respondNotAllowed();
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
