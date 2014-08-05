<?php namespace Apiv1\Factory;

use App;
use Config;

Class HomeResponseMaker {

	protected $channelFeed;
	protected $homeChannels;
	protected $channels;
	protected $response;
	protected $channelRepository;
	protected $sponsorResponder;

	public function __construct()
	{
		$this->homeChannels = Config::get('global.homeChannels'); // channels to show on the homepage
		$this->channelRepository = App::make( 'ChannelRepository' );
		$this->sponsorResponder = App::make('SponsorResponder');
	}

	public function getChannels()
	{
		$this->channels = $this->channelRepository->getChannels();

		return App::make( 'ChannelTransformer' )->transformCollection($this->channels);
	}

	public function getFeatured()
	{
		return App::make('HomeFeaturedResponder')->get();
	}

	/**
	 * return a list of articles that have been picked
	 * @return array
	 */
	public function getPicked()
	{
		$response = App::make('HomePickedResponder')->get($this->sponsorResponder);

		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		return $response['articles'];
	}	

	/**
	 * Get a channel feed object containing formatted articles organised by channel
	 * @return array
	 */
	public function getChannelFeed()
	{
        $channelFeed = App::make('ChannelFeed');	
        $channelFeed->initialise($this->homeChannels);

		$response = $channelFeed->make($this->sponsorResponder);
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		return $response['channelFeed'];
	}

	public function getWhatsOn()
	{
		$response = App::make('WhatsOnResponder')->get( $this->sponsorResponder, $this->channels );

		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		return $response['channel'];
	}

	public function make()
	{ 
		if( isApiResponse( $result = $this->getChannels() ) )
		{
			return $result;
		}

		// get 3 related adverts and set them as allocated
		$adverts = $this->sponsorResponder->getChannelSponsors(3, $this->homeChannels); 
		$this->sponsorResponder->setAllocatedSponsors($adverts);

		$this->response = [
			'channels' => $this->getChannels(),
            'adverts' => $adverts,
            'features' => $this->getFeatured(),
            'picks' => $this->getPicked(),
            'channelFeed' => $this->getChannelFeed(),
        ];

        array_unshift($this->response['channelFeed'], $this->getWhatsOn());

		return $this->response;
	}
}