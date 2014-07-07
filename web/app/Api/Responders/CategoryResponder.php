<?php namespace Api\Responders;

Class CategoryResponder {
	
	public function getCategoryMap($categoryId, $channelId)
	{
		$mapItems = \App::make('ArticleRepository')->getArticleMapObjects( $categoryId, $channelId );

		if( count($mapItems) > 0 )
		{
			$mapItems = \App::make('MapTransformer')->transformCollection( $mapItems );
		}

		return $mapItems;
	}

	public function getCategoryArticles($categoryId, $channelId)
	{
		$articles = \App::make('ArticleRepository')->getArticlesByCategory( $categoryId, $channelId );

		if( count($articles) > 0 )
		{
			$articles = \App::make('ArticleTransformer')->transformCollection( $articles );
		}

		return $articles;
	}

	public function getArticlesInRange($subChannelId, $category, $range, $time)
	{
		$articleRepository = \App::make('ArticleRepository');
		$listingTransformer = \App::make('ListingTransformer');

		$channelArticles = $articleRepository->getChannelListing( $subChannelId, 20, $range, $time );

		$articles = [];

		// see if the any of the articles returned by the call are in the provided range
		foreach( $channelArticles AS $article )
		{
			if( $article['location'][0]['categoryId'] == $category )
			{
				$articles[] = $article;
			}
		}

		return $listingTransformer->transformCollection($articles);
	}
}