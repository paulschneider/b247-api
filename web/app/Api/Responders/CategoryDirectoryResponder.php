<?php namespace Api\Responders;

use Api\Factory\ApiResponseMaker;

Class CategoryDirectoryResponder {

	public function make( $categoryId, $subChannelId, $caller )
	{
		$patternMaker = \App::make('PatternMaker');
		$categoryResponder = \App::make('CategoryResponder');
		$articleTransformer = \App::make('ArticleTransformer');

		$articles = $categoryResponder->getCategoryArticles($categoryId, $subChannelId);

		if( count($articles) == 0 )
		{
			ApiResponseMaker::RespondWithError(\Lang::get('api.noCategoryArticlesToReturn'));
		}

		return [
			'map' => $categoryResponder->getCategoryMap($categoryId, $subChannelId),
			'articles' => $articles,
		];
	}
}