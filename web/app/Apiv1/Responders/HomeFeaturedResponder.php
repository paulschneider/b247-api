<?php namespace Apiv1\Responders;

use App;

class HomeFeaturedResponder {

	public function get()
	{
		# we don't want to show as many for the apps
		if(isMobile()) {
			$limit = 5;
		}
		# else, for the web, we want to show a lot more
		else {
			$limit = 15;
		}

		# type, limit, channel, isASubChannel, ignoreChannel, 
        $articles = App::make('ArticleRepository')->getArticles( 
        	'featured',  // type of articles to get
        	$limit,  // the number to return
        	null, // channel identifier
        	false, // whether the channel is a sub channel
        	true // whether to ignore the channel identifier (we do on the homepage as we want articles for all channels) 
        );

        return App::make('ArticleTransformer')->transformCollection( $articles );
	}      
}