<?php namespace Apiv1\Responders;

use App;

Class ChannelArticleResponder {

	public function make( $articles, SponsorResponder $sponsorResponder )
	{
		$pagination = App::make('PageMaker')->make($articles);	

		$metaData = $pagination->meta;
		$articles = $pagination->items;

		$response = App::make('PatternMaker')->setPattern(1)->limit($pagination->meta->perPage)->make( [ 'articles'=> $articles, 'sponsors' => $sponsorResponder->getUnassignedSponsors() ] );

		return [
			'articles' => $response->articles,
			'pagination' => $metaData,
			'sponsors' => $response->sponsors
		];
	}

}