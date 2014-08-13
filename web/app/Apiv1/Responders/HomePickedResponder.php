<?php namespace Apiv1\Responders;

use App;
use Config;

class HomePickedResponder {

	public function get( SponsorResponder $sponsorResponder )
	{
        // get is_picked = true articles from any channel or sub-channel
        $picks = App::make('ArticleRepository')->getArticles( 
            'picks', 
            Config::get('constants.channelFeed_limit'), 
            null, // channel
            false, //isASubChannel
            true // ignoreChannel
        );

        $ads = $sponsorResponder->getUnassignedSponsors();

        $articles = App::make('ArticleTransformer')->transformCollection( $picks );
        $response = App::make('PatternMaker')->setPattern(1)->make( [ 'articles' => $articles, 'sponsors' => $ads ] );

        return [
            'articles' => $response->articles,
            'sponsors' => $response->sponsors
        ];
	}      
}