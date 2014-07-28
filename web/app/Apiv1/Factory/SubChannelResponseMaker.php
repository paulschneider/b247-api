<?php namespace Apiv1\Factory;

use Version1\Channels\Toolbox;

Class SubChannelResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	protected $response;
	protected $channel;

	public function getChannel($identifier)
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		if( ! $channel = $channelRepository->getChannelByIdentifier( $identifier ) )
		{
			return apiErrorResponse('notFound');
		}
		elseif( ! aSubChannel($channel))
		{
			return apiErrorResponse('expectationFailed');
		}

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$channel = $channelTransformer->transform( Toolbox::filterSubChannels( $parentChannel, $channel ) );

		$this->channel = $channel;
	}

	public function getChannelContent()
	{
		$channelResponder = \App::make( 'ChannelResponder' );

		$articles = $channelResponder->getArticles( $this->channel );
		$sponsors = $this->getRandomSponsors( null );

		if( isArticleType( $this->channel ) )
		{
			return $channelArticleResponse = \App::make('ChannelArticleResponder')->make( $articles, $sponsors );
		}
		else if( isDirectoryType( $this->channel ) )
		{
			return $channelDirectoryResponder = \App::make('ChannelDirectoryResponder')->make( $this->channel, $articles, $sponsors );
		}
		else if( isListingType( $this->channel ) )
		{
			return \App::make('ChannelListingResponder')->make( $this->channel );
		}

		return $channelResponder->make( $this->channel, $articles, $sponsors );
	}

	public function make( $identifier )
	{
		if( isApiResponse( $result = $this->getChannel($identifier) ) )
		{
			return $result;
		}

		$this->response = [
			'channel' => $this->channel,
			'adverts' => $this->getSponsors()
		];

		foreach( $this->getChannelContent($this->channel) AS $key => $item)
		{
			$this->response[$key] = $item;
		}

		return $this->response;
	}
}