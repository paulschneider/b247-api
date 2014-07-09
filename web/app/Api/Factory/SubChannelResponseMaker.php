<?php namespace Api\Factory;

use Version1\Channels\Toolbox;

Class SubChannelResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	public function getChannel($identifier)
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		$channel = $channelRepository->getChannelByIdentifier( $identifier );

		if( ! aSubChannel($channel) )
		{
			ApiResponseMaker::RespondWithError(\Lang::get('api.thisIsNotASubChannel'));
		}

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$channel = $channelTransformer->transform( Toolbox::filterSubChannels( $parentChannel, $channel ) );

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
			return \App::make('ChannelListingResponder')->make( $channel );
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