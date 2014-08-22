<?php namespace Apiv1\Factory;

use App;
use Apiv1\Repositories\Channels\Toolbox;

Class ChannelResponseMaker {

	/**
	 * A list of channels the use has opted out of
	 * 
	 * @var array
	 */
	protected $userInactiveChannels = [];
	
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

	/**
	 * Apiv1\Repositories\Users\User
	 * @var mixed
	 */
	protected $user = null;

	public function __construct()
	{
		$this->channelRepository = App::make( 'ChannelRepository' );
		$this->sponsorResponder = App::make( 'SponsorResponder' );

		# see if we have an user accessKey present. If so we might want to show a different view of the homepage
        if( ! isApiResponse($user = App::make('UserResponder')->verify()) ) {
        	$this->user = $user;	
        } 
	}

	public function getChannel( $identifier )
	{		
		$channel = $this->channelRepository->getChannelByIdentifier( $identifier );

		if( ! $channel ) {
			# we couldn't find the channel
			return apiErrorResponse('notFound');
		}
		elseif( aSubChannel( $channel ) ) {
			# its a sub channel so report an error (as we're trying to get a top level channel)
			return apiErrorResponse('failedDependency');	
		}

		$this->channel = App::make( 'ChannelTransformer' )->transform($channel, $this->user);
	}

	/**
	 * Get a list of articles that are picked for the specified channel
	 * 
	 * @return array $articles
	 */
	public function getPicked()
	{
		# call the responder and grab the content. Pass the user so we can filter that content by their preferences
		$response = App::make('PickedResponder')->get( $this->sponsorResponder, $this->channel, $this->user );

		# record any sponsors we may have just used so they don't get used again
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);	

		# return the articles to the caller
		return $response['articles'];	
	}

	/**
	 * A get a list of featured articles for the specified channel
	 * 
	 * @return array $articles
	 */
	public function getFeatured()
	{
		# get some featured articles for this channel
		return App::make('FeaturedResponder')->get( $this->channel, $this->user );
	}

	/**
	 * Get this channels sub-channel feed
	 * 
	 * @return array channelFeed
	 */
	public function getChannelFeed()
	{
		# get the sub-channel ID's for this channel
        $subChannels = $this->channelRepository->getChildren( $this->channel['id'] );

        # new channelFeed instance
        $channelFeed = App::make('ChannelFeed');	

        # init the channelFeed
        $channelFeed->initialise( $subChannels, $this->user, true );

        # create the channel feed
		$response = $channelFeed->make($this->sponsorResponder);

		# set any used sponsors against the allocated list
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		# and send it back
		return $response['channelFeed'];
	}

	public function make( $identifier )
	{ 
		# check to make sure we actually received an identifier
		if( is_null($identifier) ) {
            return apiErrorResponse('insufficientArguments');
        }

        # see if we can grab the channel
		if( isApiResponse($result = $this->getChannel($identifier)) ) {
			return $result;
		}

		# get 3 related adverts and set them as allocated
		$adverts = $this->sponsorResponder->setSponsorType()->getChannelSponsors(3, [$this->channel['id']]); 
		$this->sponsorResponder->setAllocatedSponsors($adverts);

		$response = [
			'channel' => $this->channel,
			'adverts' => $adverts,
			'features' => $this->getFeatured(),
			'picks' => $this->getPicked(),
			'channelFeed' => $this->getChannelFeed(),
		];

		return apiSuccessResponse( 'ok', $response );
	}
}