<?php namespace Apiv1\Responders;

use App;
use Config;

Class CategoryArticleResponder {

	public function make(SponsorResponder $sponsorResponder, $articles)
	{
		$pagination = App::make('PageMaker')->make($articles);

		$metaData = $pagination->meta;
		$articles = $pagination->items;

		$response = App::make('PatternMaker')->setPattern(1)->limit($pagination->meta->perPage)->make( [ 'articles' => $articles, 'sponsors' => $sponsorResponder->setSponsorType(Config::get('global.sponsorMPU'))->getCategorySponsors(30)->sponsors ] );

		return [
			'articles' => $response->articles,
			'pagination' => $metaData,	
			'totalArticles' => count($response->articles),
			'sponsors' => $response->sponsors
		];
	}
}