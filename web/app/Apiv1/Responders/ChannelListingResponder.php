<?php namespace Apiv1\Responders;

use Input;
use time;
use App;
use Api\Factory\ApiResponseMaker;
use ApiController;

Class ChannelListingResponder {

	public function make( $channel )
	{
        $range = Input::get('range') ? Input::get('range') : 'week';
        $time = Input::get('time') ? Input::get('time') : time();		

        $articles = App::make('ChannelResponder')->getArticlesInRange( $channel, $range, $time );	

        return [
        	'days' => $articles,
        	'numberOfDays' => count($articles)
        ];
	}
}