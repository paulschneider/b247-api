<?php namespace Apiv1\Responders;

use App;
use Input;
use Api\Factory\ApiResponseMaker;

Class CategoryListingResponder {

	public function make( $category, $subChannelId, $user )
	{
		# we only want to see article for a single day. All returned articles should 
		# have events for the same day
		$range = 'day';

		# but that day can be varied
		$time = Input::get('time') ? Input::get('time') : time();

		$articles = $this->getArticlesInRange( $subChannelId, $category, $range, $time, $user );

		return [
			'days' => $articles,
			'totalArticles' => count($articles)
		];
	}

	/**
	 * Listings are split up into ranges by day or by week. This prepares the ListingTransformer in that way
	 * 
	 * @param  int $subChannelId [identifier for the channel]
	 * @param  int $category     [identifier for the category]
	 * @param  string $range     [day || week]
	 * @param  int $time         [epoch representing the required point in time]
	 * @param  User $user        [an authenticated user so we can filter the content]
	 * @return array             [articles]
	 */
	public function getArticlesInRange($subChannelId, $category, $range, $time, $user)
	{
		$channelArticles = App::make('ArticleRepository')->getChannelListing( $subChannelId, 20, $range, $time, $user );

		$articles = [];
		$articleIds = [];

		# see if the any of the articles returned by the call are in the provided range
		foreach($channelArticles AS $article)
		{
			foreach($article['location'] AS $location)
			{
				if($location['categoryId'] == $category && !in_array($article['id'], $articleIds))
				{
					$articles[] = $article;
				}
			}

			$articleIds[] = $article['id'];
		}

		# if its a week we need to transform a whole list of articles 
		if( $range == "week" ) {
			return App::make('ListingTransformer')->transformCollection($articles);
		}
		# otherwise its just one article
		else {
			return App::make('ListingTransformer')->transform($articles, ['day' => date('Y-m-d', $time)]);
		}
	}
}