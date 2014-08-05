<?php namespace Apiv1\Responders;

use App;

class PickedResponder {

	public function get( SponsorResponder $sponsorResponder, $channel )
	{
        $picks = App::make('ArticleRepository')->getArticles( 'picks', 25, $channel['id'] );
        $articles = App::make('ArticleTransformer')->transformCollection( $picks );

        $ads = $sponsorResponder->getUnassignedSponsors();

        $response = App::make('PatternMaker')->setPattern(1)->make( [ 'articles' => $articles, 'sponsors' => $ads ] );

        return [
            'articles' => $response->articles,
            'sponsors' => $response->sponsors
        ];
	}      
}