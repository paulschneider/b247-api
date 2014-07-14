<?php namespace Api\Responders;

use Api\Factory\ApiResponseMaker;

Class CategoryDirectoryResponder {

	public function make( $categoryId, $subChannelId )
	{
		$patternMaker = \App::make('PatternMaker');
		$categoryResponder = \App::make('CategoryResponder');
		$articleTransformer = \App::make('ArticleTransformer');

		$articles = $categoryResponder->getCategoryArticles($categoryId, $subChannelId);
		$map = $categoryResponder->getCategoryMap($categoryId, $subChannelId);

		$retainedArticles = [];

		// work out which articles to keep based on the map result set
		foreach( $articles AS $article )
		{
			if( in_array($article['id'], $map->ids) )
			{
				$retainedArticles[] = $article;				
			}
		}

		$articles = $retainedArticles;

		return [
			'map' => $map->objects,
			'articles' => $articles,
			'totalArticles' => count($articles)
		];
	}
}