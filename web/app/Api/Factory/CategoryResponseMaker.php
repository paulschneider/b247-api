<?php namespace Api\Factory;

use Version1\Channels\Toolbox;

Class CategoryResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {	

	protected $subChannelId;
	protected $categoryId;
	protected $channel;

	public function getChannel($identifier, $category )
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		if( ! $channel = $channelRepository->getChannelByIdentifier( $identifier ) )
        {
        	ApiResponseMaker::RespondWithError(\Lang::get('api.channelNotFound'));
        }

		if( ! aSubChannel($channel) )
		{
			ApiResponseMaker::RespondWithError(\Lang::get('api.thisIsNotASubChannel'));
		}

		if( ! categoryBelongsToChannel( $channel, $category ) )
		{
			ApiResponseMaker::RespondWithError(\Lang::get('api.categoryDoesNotBelongToChannel'));	
		}

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$channel = $channelTransformer->transform( Toolbox::filterSubChannels( $parentChannel, $channel ) );

		$this->subChannelId = getSubChannelId($channel);

		return $channel;
	}

	public function getArticleCount()
	{
		return \App::make('ArticleRepository')->countArticlesInCategory($this->categoryId, $this->subChannelId);
	}

	public function getCategoryContent()
	{		
		if( isArticleType( $this->channel ) )
		{
			return \App::make('CategoryArticleResponder')->make($this->categoryId, $this->subChannelId, $this);
		}
		else if( isDirectoryType( $this->channel ) )
		{
			return \App::make('CategoryDirectoryResponder')->make($this->categoryId, $this->subChannelId);
		}
		else if( isListingType( $this->channel ) )
		{
			$range = 'day';
			$time = \Input::get('time') ? \Input::get('time') : \time();

			return $channelListingResponder = \App::make('CategoryListingResponder')->make( $this->categoryId, $this->subChannelId, $range, $time );
		}		
	}

	public function make($categoryId, $channel)
	{
		$this->categoryId = $categoryId;
		$this->channel = $channel;

		$response = [
			'channel' => $channel,			
            'adverts' => $this->getSponsors(),
            'totalArticles' => $this->getArticleCount(),
		];

		foreach( $this->getCategoryContent() AS $key => $content )
		{
			$response[$key] = $content;
		}

		return $response;
	}
}