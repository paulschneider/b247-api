<?php namespace Apiv1\Factory;

// this is the first draft of a simple search mechanism. It ultimately only searches article titles and organises them in a response by top level channel

use App;
use Config;

Class SearchResponseMaker {

	public function make($searchString)
	{ 	
		# carry out the generic search of articles by title
		$articles = App::make( 'ArticleRepository' )->search($searchString);

		# grab the top level channels
		$tChannels = App::make( 'ChannelRepository' )->getTopChannelIds();

		# carry out the search of articles by keyword
		$articles2 = App::make('Apiv1\Repositories\Search\SearchRepository')->keywordSearch($searchString);

		# merge the two result sets into one array to be transformed
		$articles = array_merge($articles, $articles2);

		# how many articles were returned by these searches
		$result['resultCount'] = count($articles);

		# transform the articles into the API required format
		$articleTransformer = App::make('ArticleTransformer');		

		# init a channels array
		$channels = [];

		# paginate the results of the search
		$pagination = App::make('PageMaker')->make($articles);

		$metaData = $pagination->meta;
		$articles = $pagination->items;

		# if we have some results we want to group them by channel 
		if( count($articles) > 0 )
		{
			foreach($articles AS $article)
			{
				$channelId = getChannelId($article);

				# ensure the channel list is unique
				if( ! array_key_exists($channelId, $channels) )
				{
					# create the channel data needed
					$channels[$channelId] = [
						'channel' => [
							'id' => $channelId,
							'channel' => $article['location'][0]['channelName'],
							'path' => makePath( [ $article['location'][0]['channelSefName'] ] )
						]					
					];
				}

				# transform and add the article to the channel
				$channels[$channelId]['articles'][] = $articleTransformer->transform($article);
			}	
		}
		
		# the rest of the data for the search
		$result['adverts'] 			= App::make('SponsorResponder')->setSponsorType()->getChannelSponsors(3, $tChannels); // channels to show on the homepage;
		$result['searchTerm'] 		= $searchString;				
		$result['searchResults'] 	= array_values($channels);		
		$result['pagination'] 		= $metaData;		

		return $result;
	}
}