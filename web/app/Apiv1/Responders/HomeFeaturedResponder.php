<?php namespace Apiv1\Responders;

use App;

class HomeFeaturedResponder {

	public function get()
	{
		# we don't want to show as many for the apps
		if(isMobile()) {
			$limit = 5;
		}
		# as we want to show a lot more
		else {
			$limit = 15;
		}

        $articles = App::make('ArticleRepository')->getArticles( 'featured', $limit, null, false, true );

        return App::make('ArticleTransformer')->transformCollection( $articles );
	}      
}