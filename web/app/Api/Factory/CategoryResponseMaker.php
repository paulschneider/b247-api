<?php namespace Api\Factory;

Class CategoryResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {	

	public function getCategoryMap( $categoryId, $channelId )
	{
		$categoryResponder = \App::make('CategoryResponder');

		return $categoryResponder->getCategoryMap($categoryId, $channelId);
	}

	public function getCategoryArticles( $categoryId, $channelId )
	{
		$categoryResponder = \App::make('CategoryResponder');
		$patternMaker = \App::make('PatternMaker');
		$sponsorRepository = \App::make('SponsorRepository');	

		$articles = $categoryResponder->getCategoryArticles($categoryId, $channelId);

		return $patternMaker->make( [ 'articles' => $articles, 'sponsors' => $sponsorRepository->getSponsors() ] );
	}
}