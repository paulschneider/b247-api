<?php namespace Api\Responders;

use Api\Factory\ApiResponseMaker;

Class CategoryListingResponder {

	public function make( $category, $subChannelId, $range, $time )
	{
		$patternMaker = \App::make('PatternMaker');
		$categoryResponder = \App::make('CategoryResponder');
		$articleTransformer = \App::make('ArticleTransformer');
		$categoryResponder = \App::make('CategoryResponder');

		$articles = $categoryResponder->getArticlesInRange( $subChannelId, $category, $range, $time );
		
		return [
			'days' => $articles,
			'totalArticles' => count($articles)
		];
	}
}