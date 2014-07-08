<?php namespace Api\Responders;

use Api\Factory\ApiResponseMaker;

Class ChannelListingResponder {

	public function make( $channel, $articles, $range, $time )
	{
		$listingTransformer = \App::make('ListingTransformer');

		if( $range == "week" )
        {         
            $articles = $listingTransformer->transformCollection( $articles, [ 'perDayLimit' => 3 ] );
        }
        else if( $range == "day" )
        {         
           	$articles = $listingTransformer->transform( $articles );
        }

        if( count($articles) == 0 )
        {
            ApiResponseMaker::RespondWithError(\Lang::get('api.noArticlesForSpecifiedPeriod'));
        }

        return ['articles' => $articles];
	}
}