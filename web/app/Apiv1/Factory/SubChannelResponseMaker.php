<?php namespace Apiv1\Factory;

use App;
use Apiv1\Repositories\Channels\Toolbox;

Class SubChannelResponseMaker {

	protected $response;
	protected $channel;
	protected $channelRepository;
	protected $sponsorResponder;

	/**
	 * User object
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user = null;

	public function __construct()
	{
		$this->sponsorResponder = App::make('SponsorResponder');

		# see if we have an user accessKey present. If so we might want to show a different view of the homepage
        if( ! isApiResponse($user = App::make('UserResponder')->verify()) ) {
        	$this->user = $user;	
        } 
	}

	public function getChannel($identifier)
	{
		$channelRepository = App::make( 'ChannelRepository' );

		if( ! $channel = $channelRepository->getChannelByIdentifier( $identifier ) ) {
			return apiErrorResponse('notFound');
		}
		elseif( ! aSubChannel($channel)) {
			return apiErrorResponse('expectationFailed');
		}

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$channel = App::make( 'ChannelTransformer' )->transform( Toolbox::filterSubChannels( $parentChannel, $channel ), $this->user );

		$this->channel = $channel;
	}

	public function getChannelContent()
	{
		$articles = App::make( 'ChannelResponder' )->getArticles( $this->channel, $this->user );

		// if its a channel of type - article
		if( isArticleType( $this->channel ) ) {		
			$response = App::make('ChannelArticleResponder')->make( $articles, $this->sponsorResponder );
		}
		// if its a channel of type - directory
		else if( isDirectoryType( $this->channel ) ) {
			$response = App::make('ChannelDirectoryResponder')->make( $this->channel, $articles, $this->sponsorResponder );
		}
		// if its a channel of type - listing
		else if( isListingType( $this->channel ) ) {		
			$response = App::make('ChannelListingResponder')->make( $this->channel, $this->user );
		}

		// if there were sponsors in the response we need to do something with them or they'll be returned by the API
		if(isset($response['sponsors']))
		{
			$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);	

			// we dont want to return this so get rid of it
			unset($response['sponsors']);
		}

		return $response;
	}

	public function make( $identifier )
	{
		if( isApiResponse( $result = $this->getChannel($identifier) ) )
		{
			return $result;
		}

		// get 3 related adverts and set them as allocated
		$adverts = $this->sponsorResponder->getChannelSponsors(3, [getSubChannelId($this->channel)], true); 
		$this->sponsorResponder->setAllocatedSponsors($adverts);

		$this->response = [
			'channel' => $this->channel,
			'adverts' => $adverts
		];

		// getChannelContent returns an array of content based on the channel type. Go through it and add them into the main response array
		foreach( $this->getChannelContent($this->channel) AS $key => $item)
		{
			$this->response[$key] = $item;
		}

		return $this->response;
	}
}