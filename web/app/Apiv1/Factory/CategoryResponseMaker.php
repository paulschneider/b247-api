<?php namespace Apiv1\Factory;

use Version1\Channels\Toolbox;

Class CategoryResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {	

	protected $category;
	protected $channel;

	public function getCategory($categoryIdentifier)
	{
		$categoryRepository = \App::make( 'CategoryRepository' );
		$categoryTransformer = \App::make( 'CategoryTransformer' );

		if( ! $category = $categoryRepository->getCategoryByIdentifier( $categoryIdentifier ) )
        {
        	return apiErrorResponse('notFound');
        }

        $this->category = $categoryTransformer->transform($category->toArray());

        return $this->category;
	}

	public function getChannel($identifier)
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

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
			return apiErrorResponse('failedDependency');	
		}

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$this->channel = $channelTransformer->transform( Toolbox::filterSubChannels( $parentChannel, $channel ) );

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

		if( isArticleType( $this->channel ) )
		{
			return \App::make('CategoryArticleResponder')->make($categoryId, $subChannelId, $this);
		}
		else if( isDirectoryType( $this->channel ) )
		{
			return \App::make('CategoryDirectoryResponder')->make($categoryId, $subChannelId);
		}
		else if( isListingType( $this->channel ) )
		{
			$range = 'day';
			$time = \Input::get('time') ? \Input::get('time') : \time();

			return $channelListingResponder = \App::make('CategoryListingResponder')->make( $categoryId, $subChannelId, $range, $time );
		}		
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

		$response = [
			'channel' => $this->channel,			
            'adverts' => $this->getSponsors(),
		];

		foreach( $this->getCategoryContent() AS $key => $content )
		{
			$response[$key] = $content;
		}

		return $response;
	}
}