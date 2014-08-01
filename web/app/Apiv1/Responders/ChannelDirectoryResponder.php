<?php namespace Apiv1\Responders;

use Apiv1\Repositories\Channels\Toolbox;

Class ChannelDirectoryResponder {

	public function make( $channel, $articles, $sponsors )
	{
		$articleTransformer = \App::make( 'ArticleTransformer' );
		$sponsorTransformer = \App::make( 'SponsorTransformer' );
		$articleRepository = \App::make( 'ArticleRepository' );
		$patternMaker = \App::make( 'PatternMaker' );

		$patternMaker->setPattern( 1 );

		$articles = $articleTransformer->transformCollection( $articles );
		$sponsors = $sponsorTransformer->transformCollection( $sponsors );
		
		$categories = Toolbox::getCategoryArticleCategories( $articleRepository->getChannelArticleCategory( getSubChannelId($channel) ) );

		$articles = $patternMaker->make( [ 'articles'=> $articles, 'sponsors' => $sponsors ] )->articles;

		return [
			'articles' => $articles,
			'categories' => $categories
		];
	}
}