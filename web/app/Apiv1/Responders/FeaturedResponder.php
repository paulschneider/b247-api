<?php namespace Apiv1\Responders;

use App;

class FeaturedResponder {

	public function get( $channel )
	{
        $articles = App::make('ArticleRepository')->getArticles( 'featured', 5, $channel['id'] );

        return App::make('ArticleTransformer')->transformCollection( $articles );
	}      
}