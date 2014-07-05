<?php namespace Api\Factory;

use Version1\Channels\Toolbox;

Class SubChannelResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	public function getChannel($identifier)
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		$subChannel = $channelRepository->getChannelByIdentifier( $identifier );
		$parentChannel = $channelRepository->getChannelBySubChannel( $subChannel );
		$channel = $channelTransformer->transform( Toolbox::filterSubChannels( $parentChannel, $subChannel ) );

		return $channel;
	}

	public function getChannelContent($channel)
	{
		$channelResponder = \App::make( 'ChannelResponder' );

		$articles = $channelResponder->getArticles( $channel );
		$sponsors = $this->getRandomSponsors( null );

		if( isArticleType( $channel ) )
		{
			return $channelArticleResponse = \App::make('ChannelArticleResponder')->make( $articles, $sponsors );
		}
		else if( isDirectoryType( $channel ) )
		{
			return $channelDirectoryResponder = \App::make('ChannelDirectoryResponder')->make( $channel, $articles, $sponsors );
		}
		else if( isListingType( $channel ) )
		{
			$range = \Input::get('range') ? \Input::get('range') : 'week';
			$time = \Input::get('time') ? \Input::get('time') : \time();

			$articles = $channelResponder->getArticlesInRange( $channel, $range, $time );

			return $channelListingResponder = \App::make('ChannelListingResponder')->make( $channel, $articles, $range, $time );
		}

		return $channelResponder->make( $channel, $articles, $sponsors );
	}

	public function make($channel)
	{
		$response = [
			'channel' => $channel,
			'adverts' => $this->getSponsors()
		];

		foreach( $this->getChannelContent($channel) AS $key => $item)
		{
			$response[$key] = $item;
		}

		return $response;
	}
}