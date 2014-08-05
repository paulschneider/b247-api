<?php namespace Apiv1\Factory;

use App;
use Apiv1\Repositories\Channels\Toolbox;

Class ChannelResponseMaker {

	protected $response;
	
	/**
	 * Apiv1\Repositories\ChannelRepository
	 * @var mixed
	 */
	protected $channelRepository;

	/**
	 * Apiv1\Responders\SponsorResponder
	 * @var mixed
	 */
	protected $sponsorResponder;

	public function __construct()
	{
		$this->channelRepository = App::make( 'ChannelRepository' );
		$this->sponsorResponder = App::make( 'SponsorResponder' );
	}

	public function getChannel( $identifier )
	{		
		$channel = $this->channelRepository->getChannelByIdentifier( $identifier );

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

		$this->channel = App::make( 'ChannelTransformer' )->transform($channel);
	}

	public function getPicked()
	{
		$response = App::make('PickedResponder')->get( $this->sponsorResponder, $this->channel );

		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		return $response['articles'];
	}

	public function getFeatured()
	{
		return App::make('FeaturedResponder')->get( $this->channel );
	}

	public function getChannelFeed()
	{
        $subChannels = $this->channelRepository->getChildren( $this->channel['id'] );

        $channelFeed = App::make('ChannelFeed');	
        $channelFeed->initialise( $subChannels, [], true );

		$response = $channelFeed->make($this->sponsorResponder);
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		return $response['channelFeed'];
	}

	public function make( $identifier )
	{ 
		if( isApiResponse( $result = $this->getChannel($identifier) ) )
		{
			return $result;
		}

		// get 3 related adverts and set them as allocated
		$adverts = $this->sponsorResponder->getChannelSponsors(3, [$this->channel['id']]); 
		$this->sponsorResponder->setAllocatedSponsors($adverts);

		$this->response = [
			'channel' => $this->channel,
			'adverts' => $adverts,
			'features' => $this->getFeatured(),
			'picks' => $this->getPicked(),
			'channelFeed' => $this->getChannelFeed(),
		];

		return $this->response;
	}
}