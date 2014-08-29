<?php namespace Apiv1\Responders;

use App;
use Config;

class PickedResponder {

    /**
     * Get a list of articles and sponsors to go into the Picked section of the app
     * 
     * @param  SponsorResponder $sponsorResponder
     * @param  array $channel
     * @param  Apiv1\Repositories\Users\User $user
     * @return array $response
     */
	public function get( SponsorResponder $sponsorResponder, $channel, $user )
	{
        # get some articles. Pass the user so we can check the return against their preferences
        $picks = App::make('ArticleRepository')->getArticles( 
            'picks', # what type of article
            25, # how many do we want to get
            $channel['id'], # which channel do we want to get them for
            false, # indicate whether this is a sub-channel or not
            false, # ignore that this is a specific channel and just grab articles from any channel (this is mainly done on the homepage)
            $user # if we have an authenticated user we pass them through so we can filter the content based on the preferences
        );

        # transform these articles into something the API can return
        $articles = App::make('ArticleTransformer')->transformCollection( $picks );

        # get a list of sponsors not yet used on the "page"
        $ads = $sponsorResponder->setSponsorType(Config::get('global.sponsorMPU'))->getUnassignedSponsors();

        # turn it all into something pretty
        $response = App::make('PatternMaker')->setPattern(1)->make( [ 'articles' => $articles, 'sponsors' => $ads ] );

        # and send it back
        return [
            'articles' => $response->articles,
            'sponsors' => $response->sponsors
        ];
	}      
}