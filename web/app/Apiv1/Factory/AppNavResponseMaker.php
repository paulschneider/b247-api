<?php namespace Apiv1\Factory;

use App;

Class AppNavResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	var $channels;

	public function getChannels()
	{
		$channels = App::make( 'ChannelRepository' )->getChannels();

		return App::make( 'ChannelTransformer' )->transformCollection($channels);
	}

	public function make()
	{ 
		$response = [
			'channels' => $this->getChannels()
		];

		return $response;
	}
}