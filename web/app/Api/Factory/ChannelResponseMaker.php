<?php namespace Api\Factory;

use Version1\Channels\Toolbox;

Class ChannelResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	protected $response;

	public function getChannel( $identifier )
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		$channel = $channelRepository->getChannelByIdentifier( $identifier );

		if( ! $channel )
		{
			// we couldn't find the channel
			return apiErrorResponse('notFound');
		}
		elseif( aSubChannel( $channel ) )
		{
			// its a sub channel so report an error (as we're trying to get a top level channel)
			return apiErrorResponse('failedDependency');	
		}

		$this->channel = $channelTransformer->transform($channel);
	}

	public function getChannelPicked()
	{
		return \App::make('PickedResponder')->get( $this->channel, $this );
	}

	public function getChannelFeatured()
	{
		return \App::make('FeaturedResponder')->get( $this->channel );
	}

	public function getChannelFeed()
	{
		$channelRepository = \App::make('ChannelRepository');
        $sponsorRepository = \App::make('SponsorRepository');

        $allChannels = $channelRepository->getAllChannels();
        $subChannels = $channelRepository->getChildren( $this->channel['id'] );
        $sponsors = $sponsorRepository->getWhereNotInCollection( $this->getAllocatedSponsors(), 100 )->toArray();

        $channelFeed = \App::make('ChannelFeed');	
        $channelFeed->initialise( $allChannels, $subChannels, $sponsors, [], true );

		return $channelFeed->make();
	}

	public function make( $identifier )
	{ 
		if( isApiResponse( $result = $this->getChannel($identifier) ) )
		{
			return $result;
		}

		$this->response = [
			'channel' => $this->channel,
			'adverts' => $this->getSponsors(),
			'features' => $this->getChannelFeatured(),
			'picks' => $this->getChannelPicked(),
			'channelFeed' => $this->getChannelFeed(),
		];

		return $this->response;
	}
}