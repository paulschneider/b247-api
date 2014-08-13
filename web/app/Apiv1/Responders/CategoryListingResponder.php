<?php namespace Apiv1\Responders;

use App;
use Input;
use Api\Factory\ApiResponseMaker;

Class CategoryListingResponder {

	public function make( $category, $subChannelId )
	{
		$range = 'day';
		$time = Input::get('time') ? Input::get('time') : time();

		$articles = App::make('CategoryResponder')->getArticlesInRange( $subChannelId, $category, $range, $time );

		return [
			'days' => $articles,
			'totalArticles' => count($articles)
		];
	}
}