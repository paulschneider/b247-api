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

	/**
	 * get all of the article in a particular category
	 * 
	 * @param  int $categoryId [identifier for the category]
	 * @param  int $channelId  [identifier for the channel]
	 * @return array           [articles]
	 */
	public function getCategoryArticles($categoryId, $channelId)
	{
		$articles = App::make('ArticleRepository')->getArticlesByCategory( $categoryId, $channelId );

		if( count($articles) > 0 ) {
			$articles = App::make('ArticleTransformer')->transformCollection( $articles );
		}

		return $articles;
	}
}