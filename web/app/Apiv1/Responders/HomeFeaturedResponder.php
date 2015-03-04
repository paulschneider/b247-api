<?php namespace Apiv1\Responders;

use App;

class HomeFeaturedResponder {

	public function get()
	{
		# set a limit for how many articles we want to return
		$limit = 5;
		
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