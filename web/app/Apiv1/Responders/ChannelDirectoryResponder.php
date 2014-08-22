<?php namespace Apiv1\Responders;

use App;
use Apiv1\Repositories\Channels\Toolbox;

Class ChannelDirectoryResponder {

	public function make( $channel, $articles, SponsorResponder $sponsorResponder )
	{	
		## Note - the articles here are is_featured = true. The count returned below is of all articles in that sub-channel split between their assigned categories
		## and not of the articles being returned.

		# get a list of articles assigned to this sub-channel based on their category
		$categories = App::make( 'ArticleRepository' )->getChannelArticleCategory( getSubChannelId($channel));

		# go through each of the article categories returned and get a counter. This is a total count of ALL articles
		# in each category. This is **NOT** the number of articles returned to the page
		$sortedCategories = Toolbox::getCategoryArticleCategories( $categories );

		# create the desired pattern
		$response = App::make( 'PatternMaker' )->setPattern( 1 )->make( [ 'articles'=> $articles, 'sponsors' => $sponsorResponder->setSponsorType(Config::get('global.sponsorMPU')->getUnassignedSponsors() ] );

		# return all the data requested
		return [
			'articles' => $response->articles,
			'categories' => $sortedCategories,
			'sponsors' => $response->sponsors
		];
	}
}