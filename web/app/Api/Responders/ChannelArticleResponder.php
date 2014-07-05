<?php namespace Api\Responders;

Class ChannelArticleResponder {

	public function make( $articles, $sponsors )
	{
		$pagination = \App::make('PageMaker')->make($articles);	
		$articleTransformer = \App::make('ArticleTransformer');
		$sponsorTransformer = \App::make('SponsorTransformer');

		$metaData = $pagination->meta;
		$articles = $pagination->items;

		$patternMaker = \App::make('PatternMaker');
		$patternMaker->setPattern(1);

		$articles = $articleTransformer->transformCollection( $articles );
		$sponsors = $sponsorTransformer->transformCollection( $sponsors );

		return [
			'articles' => $patternMaker->make( [ 'articles'=> $articles, 'sponsors' => $sponsors ] )->articles,
			'pagination' => $metaData
		];
	}

}