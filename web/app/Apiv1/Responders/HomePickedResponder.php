<?php namespace Apiv1\Responders;

use App;
use Config;

class HomePickedResponder {

    /**
     * get a list of articles for the homepage picked section
     * 
     * @param  SponsorResponder $sponsorResponder 
     * @param  Apiv1\Repositories\Users\User $user
     * @return mixed
     */
	public function get( SponsorResponder $sponsorResponder, $user )
	{
        # get is_picked = true articles from any channel or sub-channel
        $picks = App::make('ArticleRepository')->getArticles( 
            'picks', 
            Config::get('constants.channelFeed_limit'), 
            null, // channel
            false, //isASubChannel
            true, // ignoreChannel
            $user // a user object
        );

        # grab some sponsors that have yet to be assigned anywhere on the current page
        $ads = $sponsorResponder->setSponsorType(Config::get('global.sponsorMPU'))->getUnassignedSponsors();

        $articles = App::make('ArticleTransformer')->transformCollection( $picks );
        $response = App::make('PatternMaker')->setPattern(1)->make( [ 'articles' => $articles, 'sponsors' => $ads ] );

        return [
            'articles' => $response->articles,
            'sponsors' => $response->sponsors
        ];
	}      
}