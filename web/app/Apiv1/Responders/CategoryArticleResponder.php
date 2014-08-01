<?php namespace Apiv1\Responders;

use Api\Factory\ApiResponseMaker;

Class CategoryArticleResponder {

	public function make( $categoryId, $subChannelId, $caller )
	{
		$patternMaker = \App::make('PatternMaker');
		$sponsorRepository = \App::make('SponsorRepository');
		$categoryResponder = \App::make('CategoryResponder');

		$articleTransformer = \App::make('ArticleTransformer');
		$sponsorTransformer = \App::make('SponsorTransformer');

		$articles = $categoryResponder->getCategoryArticles($categoryId, $subChannelId);

		$pagination = \App::make('PageMaker')->make($articles);

		$metaData = $pagination->meta;
		$articles = $pagination->items;

		$sponsors = $sponsorRepository->getWhereNotInCollection( $caller->getAllocatedSponsors(), 30 )->toArray();
		$articles = $patternMaker->make( [ 'articles' => $articles, 'sponsors' => $sponsorTransformer->transformCollection($sponsors) ] )->articles;

		return [
			'articles' => $articles,
			'pagination' => $metaData,	
			'totalArticles' => count($articles)
		];
	}
}