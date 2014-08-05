<?php namespace Apiv1\Factory;

// this is the first draft of a simple search mechanism. It ultimately only searches article titles and organises them in a response by top level channel

use App;
use Config;

Class SearchResponseMaker {

	public function make($searchString)
	{ 	
		$articles = App::make( 'ArticleRepository' )->search($searchString);
		$articleTransformer = App::make('ArticleTransformer');		
		$channels = [];

		$pagination = App::make('PageMaker')->make($articles);

		$metaData = $pagination->meta;
		$articles = $pagination->items;

		if( count($articles) > 0 )
		{
			foreach($articles AS $article)
			{
				$channelId = getChannelId($article);

				if( ! array_key_exists($channelId, $channels) )
				{
					$channels[$channelId] = [
						'channel' => [
							'id' => $channelId,
							'channel' => $article['location'][0]['channelName'],
							'path' => makePath( [ $article['location'][0]['channelSefName'] ] )
						]					
					];
				}

				$channels[$channelId]['articles'][] = $articleTransformer->transform($article);
			}	
		}
		
		$result['adverts'] = App::make('SponsorResponder')->getChannelSponsors(3, Config::get('global.homeChannels')); // channels to show on the homepage;
		$result['searchResults'] = array_values($channels);
		$result['resultCount'] = count($articles);
		$result['pagination'] = $metaData;		

		return $result;
	}
}