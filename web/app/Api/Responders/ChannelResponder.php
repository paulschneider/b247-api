<?php namespace Api\Responders;

use Version1\Channels\Toolbox;
use \Carbon\Carbon;

Class ChannelResponder {

	public function getChannel( $identifier )
	{
		$channelRepository = \App::make( 'ChannelRepository' );
		$channelTransformer = \App::make( 'ChannelTransformer' );

		$channel = $channelRepository->getChannelByIdentifier( $identifier );

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$channel = $channelTransformer->transform( Toolbox::filterSubChannels( $parentChannel, $channel ) );

		return $channel;
	}

	public function getArticles($channel)
	{	
		$articleRepository = \App::make('ArticleRepository');

		$type = getSubChannelType( $channel );
		$subChannelId = getSubChannelId($channel);		

		return $articleRepository->getArticles( $type, 25, $subChannelId, true ); 
	}

	public function getArticlesInRange($channel, $range, $time)
	{
		$articleRepository = \App::make('ArticleRepository');
		$listingTransformer = \App::make('ListingTransformer');

		$subChannelId = getSubChannelId($channel);

		$articles = $articleRepository->getChannelListing( $subChannelId, 20, $range, $time );

		if( $range == "week" )
        {
        	$days = [];

        	$dateStamp = convertTimestamp( 'Y-m-d', $time);

        	$dateArray = explode('-', $dateStamp); 

        	for( $i = 0; $i < 7; $i++ )
        	{
        		if( $i == 0 )
        		{
        			$date = Carbon::create($dateArray[0], $dateArray[1], $dateArray[2], '00', '00', '01')->toDateString();

        			$days[$date] = [];
        		}
        		else
        		{
        			$dateArray = explode('-', $date); 
        			$date = Carbon::create($dateArray[0], $dateArray[1], $dateArray[2], '00', '00', '01')->addDays(1)->toDateString();

        			$days[$date] = [];
        		}
        	}

            return $listingTransformer->transformCollection( $articles, [ 'perDayLimit' => 3, 'days' => $days ] );
        }
        else if( $range == "day" )
        {         
           	$articles = $listingTransformer->transform( $articles );
        }

        return $articles;
	}
}