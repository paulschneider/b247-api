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
}