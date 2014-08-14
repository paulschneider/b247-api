<?php namespace Apiv1\Responders;

use App;

class HomeFeaturedResponder {

	public function get($user)
	{
        $articles = App::make('ArticleRepository')->getArticles( 'featured', 5, null, false, true, $user );

        return App::make('ArticleTransformer')->transformCollection( $articles );
	}      
}