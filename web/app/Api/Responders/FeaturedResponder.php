<?php namespace Api\Responders;

class FeaturedResponder {

	public function get( $channel )
	{
		$articleRepository = \App::make('ArticleRepository');
		$articleTransformer = \App::make('ArticleTransformer');

        $articles = $articleRepository->getArticles( 'featured', 25, $channel['id'] );

        return $articleTransformer->transformCollection( $articles );
	}      
}