<?php namespace Apiv1\Responders;

use App;
use Input;
use stdClass;

Class CategoryResponder {
	
	public function getCategoryMap($categoryId, $channelId)
	{
		$lat = Input::get('lat') ? Input::get('lat') : 51.451508;
		$lon = Input::get('lon') ? Input::get('lon') : -2.598464;
		$distance = Input::get('dist') ? Input::get('dist') : 10;

		$mapItems = App::make('ArticleRepository')->getArticleMapObjects( $categoryId, $channelId, $lat, $lon, $distance );

		if( count($mapItems) > 0 )
		{
			$mapItems = App::make('MapTransformer')->transformCollection( $mapItems );
		}

		$ids = [];

		foreach($mapItems AS $item)
		{
			$ids[] = $item['id'];
		}

		$map = new stdClass();

		$map->ids = $ids;
		$map->objects = $mapItems;

		return $map;
	}

	public function getCategoryArticles($categoryId, $channelId)
	{
		$articles = App::make('ArticleRepository')->getArticlesByCategory( $categoryId, $channelId );

		if( count($articles) > 0 )
		{
			$articles = App::make('ArticleTransformer')->transformCollection( $articles );
		}

		return $articles;
	}

	public function getArticlesInRange($subChannelId, $category, $range, $time, $user)
	{
		$channelArticles = App::make('ArticleRepository')->getChannelListing( $subChannelId, 20, $range, $time, $user );

		$articles = [];

		// see if the any of the articles returned by the call are in the provided range
		foreach( $channelArticles AS $article )
		{
			if( $article['location'][0]['categoryId'] == $category )
			{
				$articles[] = $article;
			}
		}

		if( $range == "week" )
		{
			return App::make('ListingTransformer')->transformCollection($articles);
		}
		else
		{
			return App::make('ListingTransformer')->transform($articles, ['day' => date('Y-m-d', $time)]);
		}
	}
}