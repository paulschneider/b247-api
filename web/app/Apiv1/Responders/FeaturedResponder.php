<?php namespace Apiv1\Responders;

use App;

class FeaturedResponder {

	/**
	 * Retrieve a list of articles marked as featured for a specified channel
	 * @param  array $channel
	 * @param  Apiv1\Repositories\Users\User $user
	 * 
	 * @return array $articles
	 */
	public function get( $channel, $user )
	{
		# we don't want to show as many for the apps
		if(isMobile()) {
			$limit = 5;
		}
		# else, for the web, we want to show a lot more
		else {
			$limit = 15;
		}

        $articles = App::make('ArticleRepository')->getArticles( 
        	'featured', # the type of article we wan to retrieve
        	$limit, # how many do we want
        	$channel['id'], # for which channel
        	false, # its not a sub-channel
        	false, # don't ignore the channel. Used to retrieve a random list of adverts from any channel
        	$user # an authenticated user (possibly), so we can check their preferences 
        );

        # turn the retrieved articles into the API response format
        return App::make('ArticleTransformer')->transformCollection( $articles );
	}      
}