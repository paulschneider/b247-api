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

		$articles = App::make('CategoryResponder')->getArticlesInRange( $subChannelId, $category, $range, $time, $user );

		return [
			'days' => $articles,
			'totalArticles' => count($articles)
		];
	}
}