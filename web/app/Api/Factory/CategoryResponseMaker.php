<?php namespace Api\Factory;

use Version1\Channels\Toolbox;

Class CategoryResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {	

	protected $subChannelId;

	public function getChannel($identifier)
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		$channel = $channelRepository->getChannelByIdentifier( $identifier );

		if( ! aSubChannel($channel) )
		{
			ApiResponseMaker::RespondWithError(\Lang::get('api.thisIsNotASubChannel'));
		}

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$channel = $channelTransformer->transform( Toolbox::filterSubChannels( $parentChannel, $channel ) );

		$this->subChannelId = getSubChannelId($channel);

		return $channel;
	}

	public function getArticleCount($categoryId)
	{
		$articleRepository = \App::make('ArticleRepository');

		return $articleRepository->countArticlesInCategory($categoryId, $this->subChannelId);
	}

	public function getCategoryMap( $categoryId )
	{
		$categoryResponder = \App::make('CategoryResponder');

		return $categoryResponder->getCategoryMap($categoryId, $this->subChannelId);
	}

	public function getCategoryArticles( $categoryId )
	{
		$categoryResponder = \App::make('CategoryResponder');
		$patternMaker = \App::make('PatternMaker');
		$sponsorRepository = \App::make('SponsorRepository');	

		$articles = $categoryResponder->getCategoryArticles($categoryId, $this->subChannelId);
		$sponsors = $sponsorRepository->getWhereNotInCollection( $this->getAllocatedSponsors(), 30 )->toArray();
		return $patternMaker->make( [ 'articles' => $articles, 'sponsors' => $sponsors ] )->articles;
	}

	public function make($categoryId, $channel)
	{
		return [
			'resultCount' => $this->getArticleCount($categoryId),
            'adverts' => $this->getSponsors(),
            'map' => $this->getCategoryMap($categoryId),
            'articles' => $this->getCategoryArticles($categoryId),
		];
	}
}