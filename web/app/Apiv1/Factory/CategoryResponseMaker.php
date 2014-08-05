<?php namespace Apiv1\Factory;

use App;
use Input;
use Apiv1\Repositories\Channels\Toolbox;

Class CategoryResponseMaker {	

	protected $category;
	protected $channel;
	protected $sponsorResponder;

	public function __construct()
	{
		$this->sponsorResponder = App::make('SponsorResponder');
	}

	public function getCategory($categoryIdentifier)
	{
		if( ! $category = App::make( 'CategoryRepository' )->getCategoryByIdentifier( $categoryIdentifier ) )
        {
        	return apiErrorResponse('notFound');
        }

        $this->category = App::make( 'CategoryTransformer' )->transform($category->toArray());

        return $this->category;
	}

	public function getChannel($identifier)
	{
		$channelRepository = App::make( 'ChannelRepository' );

		if( ! $channel = $channelRepository->getChannelByIdentifier( $identifier ) )
        {
        	return apiErrorResponse('notFound');
        }

		if( ! aSubChannel($channel) )
		{
			return apiErrorResponse('expectationFailed');
		}

		if( ! categoryBelongsToChannel( $channel, $this->category['id'] ) )
		{
			return apiErrorResponse('failedDependency', [ 'ErrorReason' => "Supplied channel is not a sub-channel." ]);	
		}

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$this->channel = App::make( 'ChannelTransformer' )->transform( Toolbox::filterSubChannels( $parentChannel, $channel ) );

		// remove all other categories except the one requested
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

		$articles = App::make('CategoryResponder')->getCategoryArticles($categoryId, $subChannelId);

		// ARTICLE type articles
		if( isArticleType( $this->channel ) )
		{
			$response = App::make('CategoryArticleResponder')->make($this->sponsorResponder, $articles);
		}
		// DIRECTORY type articles
		else if( isDirectoryType( $this->channel ) )
		{
			$response = App::make('CategoryDirectoryResponder')->make($articles, $categoryId, $subChannelId);
		}
		// LISTING type articles
		else if( isListingType( $this->channel ) )
		{
			$response = App::make('CategoryListingResponder')->make( $categoryId, $subChannelId );
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

		$adverts = $this->sponsorResponder->getCategorySponsors(3); 
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