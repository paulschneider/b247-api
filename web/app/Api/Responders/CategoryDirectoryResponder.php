<?php namespace Api\Responders;

use Api\Factory\ApiResponseMaker;

Class CategoryDirectoryResponder {

	public function make( $categoryId, $subChannelId )
	{
		$patternMaker = \App::make('PatternMaker');
		$categoryResponder = \App::make('CategoryResponder');
		$articleTransformer = \App::make('ArticleTransformer');

		$articles = $categoryResponder->getCategoryArticles($categoryId, $subChannelId);

		return [
			'map' => $categoryResponder->getCategoryMap($categoryId, $subChannelId),
			'articles' => $articles,
		];
	}
}