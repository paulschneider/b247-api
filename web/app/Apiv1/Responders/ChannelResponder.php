<?php namespace Apiv1\Responders;

use Apiv1\Repositories\Channels\Toolbox;
use Carbon\Carbon;
use App;

Class ChannelResponder {

	public function getChannel( $identifier, $user )
	{
		$channelRepository = App::make( 'ChannelRepository' );
		$channel = $channelRepository->getChannelByIdentifier( $identifier );

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$channel = App::make( 'ChannelTransformer' )->transform( Toolbox::filterSubChannels( $parentChannel, $channel ), $user );

		return $channel;
	}

	public function getArticles($channel, $user)
	{	
        # the channel type (article, listing, directory, promotion)
		$type = getSubChannelType( $channel );

        #grab the sub-channel ID from the main channel array
		$subChannelId = getSubChannelId($channel);		

        # get some articles
		$articles = App::make('ArticleRepository')->getArticles( $type, 25, $subChannelId, true, false, $user ); 

        # transform the response into the API required format
        return App::make('ArticleTransformer')->transformCollection($articles);
    }

	public function getArticlesInRange($channel, $range, $time, $user)
	{
		$subChannelId = getSubChannelId($channel);

		$articles = App::make('ArticleRepository')->getChannelListing( $subChannelId, 20, $range, $time, $user );

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

            return App::make('ListingTransformer')->transformCollection( $articles, [ 'perDayLimit' => 3, 'days' => $days ] );
        }
        else if( $range == "day" )
        {         
           	$articles = App::make('ListingTransformer')->transform( $articles, ['day' => date('Y-m-d', $time)] );
        }

        return $articles;
	}
}