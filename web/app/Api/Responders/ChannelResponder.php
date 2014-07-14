<?php namespace Api\Responders;

use Version1\Channels\Toolbox;

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
            $articles = $listingTransformer->transformCollection( $articles, [ 'perDayLimit' => 3 ] );
        }
        else if( $range == "day" )
        {         
           	$articles = $listingTransformer->transform( $articles );
        }

        return $articles;
	}
}