<?php namespace Apiv1\Factory;

use App;
use Config;

Class HomeResponseMaker {

	protected $channelFeed;
	protected $homeChannels;
	protected $channels;
	protected $channelRepository;
	protected $sponsorResponder;

	/**
	 * User object
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user = null;

	public function __construct()
	{
		$this->homeChannels = Config::get('global.homeChannels'); // channels to show on the homepage
		$this->channelRepository = App::make( 'ChannelRepository' );
		$this->sponsorResponder = App::make('SponsorResponder');

		# see if we have an user accessKey present. If so we might want to show a different view of the homepage
        if( ! isApiResponse($user = App::make('UserResponder')->verify()) ) {
        	$this->user = $user;	
        }        
	}

	public function getChannels()
	{
		$this->channels = $this->channelRepository->getChannels();

		return App::make( 'ChannelTransformer' )->transformCollection($this->channels, $this->user);
	}

	public function getFeatured()
	{
		return App::make('HomeFeaturedResponder')->get($this->user);
	}

	/**
	 * return a list of articles that have been picked
	 * @return array
	 */
	public function getPicked()
	{
		$response = App::make('HomePickedResponder')->get($this->sponsorResponder, $this->user);
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		return $response['articles'];
	}	

	/**
	 * Get a channel feed object containing formatted articles organised by channel
	 * 
	 * @return array
	 */
	public function getChannelFeed()
	{
        # create and initialise a channel feed
        $channelFeed = App::make('ChannelFeed');	
        $channelFeed->initialise($this->homeChannels, $this->user);

        # construct the channel feed
       	$response = $channelFeed->make($this->sponsorResponder);

       	# grab any sponsors that were used when creating the channel feed
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		# add the whats on content to the beginning of the channelFeed
		$whatsOn = $this->getWhatsOn();

		# whats on is handled slightly differently. Check the use hasn't disabled it then add it to
		# the response array
		if( is_null($this->user) || ! in_array($whatsOn['id'], $this->user->inactive_channels) ) {
			array_unshift($response['channelFeed'], $whatsOn);
		}

		return $response['channelFeed'];
	}

	public function getWhatsOn()
	{
		$response = App::make('WhatsOnResponder')->get( $this->sponsorResponder, $this->channels, $this->user );

		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		return $response['channel'];
	}

	/**
	 * From the various methods in this class create a response object for the homepage
	 * 
	 * @return mixed 
	 */
	public function make()
	{ 
		# try and find the channels. If not, return the response returned by the call
		if( isApiResponse( $result = $this->getChannels() ) ) {
			return $result;
		}

		# get 3 related adverts and set them as allocated
		$adverts = $this->sponsorResponder->getChannelSponsors(3, $this->homeChannels); 
		$this->sponsorResponder->setAllocatedSponsors($adverts);

		# the main response array
		$response = [
			'channels' => $this->getChannels(),
            'adverts' => $adverts,
            'features' => $this->getFeatured(),
            'picks' => $this->getPicked(),
            'channelFeed' => $this->getChannelFeed(),
        ];        

		return apiSuccessResponse( 'ok', $response ); 
	}
}