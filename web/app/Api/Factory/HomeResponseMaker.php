<?php namespace Api\Factory;

Class HomeResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	protected $channelFeed;
	protected $homeChannels = [ 48, 49, 51, 52 ];
	protected $channels;
	protected $response;

	public function getChannels()
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		$this->channels = $channelRepository->getChannels();

		$this->response['channels']  = $channelTransformer->transformCollection($this->channels);
	}

	public function getFeatured()
	{
		return \App::make('HomeFeaturedResponder')->get();
	}

	public function getPicked()
	{
		return \App::make('HomePickedResponder')->get( $this );
	}

	public function getWhatsOn()
	{
		$sponsorRepository = \App::make('SponsorRepository');

		$sponsors = $sponsorRepository->getWhereNotInCollection( $this->getAllocatedSponsors(), 100 )->toArray();

		return \App::make('WhatsOnResponder')->get( $sponsors, $this, $this->channels );
	}

	public function getChannelFeed()
	{
		$channelRepository = \App::make('ChannelRepository');
        $sponsorRepository = \App::make('SponsorRepository');

        $allChannels = $channelRepository->getAllChannels();
        $sponsors = $sponsorRepository->getWhereNotInCollection( $this->getAllocatedSponsors(), 100 )->toArray();

        $channelFeed = \App::make('ChannelFeed');	
        $channelFeed->initialise( $allChannels, $this->homeChannels, $sponsors, [] );

		$this->channelFeed = $channelFeed->make();

		return $this->channelFeed;
	}

	public function make()
	{ 
		if( isApiResponse( $result = $this->getChannels() ) )
		{
			return $result;
		}

		$this->response = [
            'adverts' => $this->getSponsors(),
            'features' => $this->getFeatured(),
            'picks' => $this->getPicked(),
            'channelFeed' => $this->getChannelFeed(),
        ];

        array_unshift($this->response['channelFeed'], $this->getWhatsOn());

		return $this->response;
	}
}