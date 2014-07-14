<?php namespace Api\Responders;

class HomeFeaturedResponder {

	public function get()
	{
		$articleRepository = \App::make('ArticleRepository');
		$articleTransformer = \App::make('ArticleTransformer');

        $articles = $articleRepository->getArticles( 'featured', 5, null, false, true );

        return $articleTransformer->transformCollection( $articles );
	}      
}