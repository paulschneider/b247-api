<?php namespace Apiv1\Responders;

use App;

class HomeFeaturedResponder {

	public function get()
	{
        $articles = App::make('ArticleRepository')->getArticles( 'featured', 15, null, false, true );

        return App::make('ArticleTransformer')->transformCollection( $articles );
	}      
}