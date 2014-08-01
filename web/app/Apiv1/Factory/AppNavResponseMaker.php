<?php namespace Apiv1\Factory;

Class AppNavResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	var $channels;

	public function getChannels()
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		$channels = $channelRepository->getChannels();

		return $channelTransformer->transformCollection($channels);
	}

	public function make()
	{ 
		$response = [
			'channels' => $this->getChannels()
		];

		return $response;
	}
}