<?php namespace Api\Responders;

Class ChannelListingResponder {

	public function make( $channel, $articles, $range, $time )
	{
		$listingTransformer = \App::make('ListingTransformer');

		if( $range == "week" )
        {         
            return [
            	'days' => $listingTransformer->transformCollection( $articles, [ 'perDayLimit' => 3 ] )
            ];
        }
        else if( $range == "day" )
        {         
            return [
            	'days' => $listingTransformer->transform( $articles )
            ];
        }
	}
}