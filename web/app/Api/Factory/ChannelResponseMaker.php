<?php namespace Api\Factory;

use Version1\Channels\Toolbox;

Class ChannelResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	public function getChannel( $identifier )
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		$channel = $channelRepository->getChannelByIdentifier( $identifier );

		if( ! $channel )
		{
			return false;
		}

		return $channelTransformer->transform($channel);
	}

	public function getChannelPicked( $channel )
	{
		return \App::make('PickedResponder')->get( $channel, $this );
	}

	public function getChannelFeatured( $channel )
	{
		return \App::make('FeaturedResponder')->get( $channel );
	}

	public function getChannelFeed( $channel )
	{
		$channelRepository = \App::make('ChannelRepository');
        $sponsorRepository = \App::make('SponsorRepository');

        $allChannels = $channelRepository->getAllChannels();
        $subChannels = $channelRepository->getChildren( $channel['id'] );
        $sponsors = $sponsorRepository->getWhereNotInCollection( $this->getAllocatedSponsors(), 100 )->toArray();

        $channelFeed = \App::make('ChannelFeed');	
        $channelFeed->initialise( $allChannels, $subChannels, $sponsors, [], true );

		return $channelFeed->make();
	}

	public function make( $channel )
	{ 
		$response = [
			'channel' => $channel,
			'adverts' => $this->channelSponsors,
			'features' => $this->getChannelFeatured( $channel ),
			'picks' => $this->getChannelPicked( $channel ),
			'channelFeed' => $this->getChannelFeed( $channel ),
		];

		return $response;
	}
}