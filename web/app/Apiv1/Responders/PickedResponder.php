<?php namespace Apiv1\Responders;

use App;

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
        $picks = App::make('ArticleRepository')->getArticles( 'picks', 25, $channel['id'], true, false, $user );

        # transform these articles into something the API can return
        $articles = App::make('ArticleTransformer')->transformCollection( $picks );

        # get a list of sponsors not yet used on the "page"
        $ads = $sponsorResponder->getUnassignedSponsors();

        # turn it all into something pretty
        $response = App::make('PatternMaker')->setPattern(1)->make( [ 'articles' => $articles, 'sponsors' => $ads ] );

        # and send it back
        return [
            'articles' => $response->articles,
            'sponsors' => $response->sponsors
        ];
	}      
}