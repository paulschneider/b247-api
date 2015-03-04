<?php namespace Apiv1\Responders;

use App;
use Config;

Class ChannelArticleResponder {

	public function make( $articles, SponsorResponder $sponsorResponder )
	{
		$pagination = App::make('PageMaker')->make($articles);	

		$metaData = $pagination->meta;
		$articles = $pagination->items;

		$response = App::make('PatternMaker')->setPattern(3)->limit($pagination->meta->perPage)->make( [ 'articles'=> $articles, 'sponsors' => $sponsorResponder->setSponsorType(Config::get('global.sponsorMPU'))->getUnassignedSponsors() ] );

		return [
			'articles' => $response->articles,			
			'sponsors' => $response->sponsors,
			'pagination' => $metaData,
		];
	}

}