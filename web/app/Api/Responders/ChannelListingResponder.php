<?php namespace Api\Responders;

use Api\Factory\ApiResponseMaker;
use ApiController;

Class ChannelListingResponder {

	public function make( $channel )
	{
        $range = \Input::get('range') ? \Input::get('range') : 'week';
        $time = \Input::get('time') ? \Input::get('time') : \time();

		$listingTransformer = \App::make('ListingTransformer');

        $articles = \App::make('ChannelResponder')->getArticlesInRange( $channel, $range, $time );

		if( $range == "week" )
        {         
            $articles = $listingTransformer->transformCollection( $articles, [ 'perDayLimit' => 3 ] );
        }
        else if( $range == "day" )
        {         
           	$articles = $listingTransformer->transform( $articles );
        }

        return ['days' => $articles];
	}
}