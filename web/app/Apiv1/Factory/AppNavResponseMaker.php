<?php namespace Apiv1\Factory;

use App;

Class AppNavResponseMaker {

	var $channels;

	/**
	 * User object
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user = null;

	public function __construct()
	{
		# see if we have an user accessKey present. If so we might want to show a different view of the homepage
        if( ! isApiResponse($user = App::make('UserResponder')->verify()) ) {
        	$this->user = $user;	
        }        
	}

	public function getChannels()
	{
		$channels = App::make( 'ChannelRepository' )->getChannels();

		return App::make( 'ChannelTransformer' )->transformCollection($channels, $this->user);
	}

	public function make()
	{ 
		$response = [
			'channels' => $this->getChannels()
		];

		return $response;
	}
}