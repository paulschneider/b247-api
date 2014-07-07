<?php namespace Api\Responders;

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

		if( count($articles) == 0 )
		{
			ApiResponseMaker::RespondWithError(\Lang::get('api.noCategoryArticlesToReturn'));
		}

		$pagination = \App::make('PageMaker')->make($articles);

		$metaData = $pagination->meta;
		$articles = $pagination->items;

		$sponsors = $sponsorRepository->getWhereNotInCollection( $caller->getAllocatedSponsors(), 30 )->toArray();
		$articles = $patternMaker->make( [ 'articles' => $articles, 'sponsors' => $sponsorTransformer->transformCollection($sponsors) ] )->articles;

		return [
			'articles' => $articles,
			'pagination' => $metaData,v
		];
	}
}