<?php namespace Apiv1\Factory;

use App;
use Input;
use Apiv1\Repositories\Channels\Toolbox;

Class CategoryResponseMaker {	

	protected $category;
	protected $channel;
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

	public function getCategory($categoryIdentifier)
	{	
		# try and find the category by the supplied identifier
		if( ! $category = App::make( 'CategoryRepository' )->getCategoryByIdentifier( $categoryIdentifier ) ) {
        	return apiErrorResponse('notFound');
        }

        # transform the category into the API required format
        $this->category = App::make( 'CategoryTransformer' )->transform($category->toArray());

        # send it back
        return $this->category;
	}

	public function getChannel($identifier)
	{
		$channelRepository = App::make( 'ChannelRepository' );

		# if we can't find the channel by the supplied identifier then we can't go any further
		if( ! $channel = $channelRepository->getChannelByIdentifier( $identifier ) ) {
        	return apiErrorResponse('notFound');
        }

        # if its not a sub-channel identifier then reject the request
		if( ! aSubChannel($channel) ) {
			return apiErrorResponse('expectationFailed');
		}
 	
 		# make sure the requested category/channel combination is valid
		if( ! categoryBelongsToChannel( $channel, $this->category['id'] ) ) {
			return apiErrorResponse('failedDependency', [ 'ErrorReason' => "Supplied channel is not a sub-channel." ]);	
		}

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$this->channel = App::make( 'ChannelTransformer' )->transform( Toolbox::filterSubChannels( $parentChannel, $channel ), $this->user );

		# remove all other categories except the one requested
		foreach( $this->channel['subChannels'][0]['categories'] AS $key => $category )
		{
			if( $category['id'] == $this->category['id'] )
			{
				$this->channel['subChannels'][0]['categories'] = [$category];
				break;
			}
		}

		return $this->channel;
	}

	public function getCategoryContent()
	{	
		$categoryId = $this->category['id'];
		$subChannelId = getSubChannelId($this->channel);

		$articles = App::make('CategoryResponder')->getCategoryArticles($categoryId, $subChannelId, $this->user);

		# ARTICLE type articles
		if( isArticleType( $this->channel ) )
		{
			$response = App::make('CategoryArticleResponder')->make($this->sponsorResponder, $articles, $this->user);
		}
		# DIRECTORY type articles
		else if( isDirectoryType( $this->channel ) )
		{
			$response = App::make('CategoryDirectoryResponder')->make($articles, $categoryId, $subChannelId, $this->user);
		}
		# LISTING type articles
		else if( isListingType( $this->channel ) )
		{
			$response = App::make('CategoryListingResponder')->make( $categoryId, $subChannelId, $this->user );
		}

		# if there were sponsors in the response we need to do something with them or they'll be returned by the API
		if(isset($response['sponsors']))
		{
			$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);	

			# we dont want to return this so get rid of it
			unset($response['sponsors']);
		}		

		return $response;
	}

	public function make($categoryIdentifier, $channelId)
	{
		if( isApiResponse( $result = $this->getCategory($categoryIdentifier) ))
        {
            return $result;
        }

        if( isApiResponse( $result = $this->getChannel( $channelId )) )
        {
        	return $result;	
        }

        // get 3 related adverts and set them as allocated
        $this->sponsorResponder->channel = $this->channel;
        $this->sponsorResponder->category = $this->category;

		$adverts = $this->sponsorResponder->getCategorySponsors(3)->sponsors; 
		$this->sponsorResponder->setAllocatedSponsors($adverts);

		$response = [
			'channel' => $this->channel,			
            'adverts' => $adverts,
		];

		foreach( $this->getCategoryContent() AS $key => $content )
		{
			$response[$key] = $content;
		}

		return $response;
	}
}