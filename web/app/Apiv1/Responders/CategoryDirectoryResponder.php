<?php namespace Apiv1\Responders;

use App;

Class CategoryDirectoryResponder {

	public function make( $articles, $categoryId, $subChannelId )
	{
		## Use a provided array of articles to create map objects with lat and lons for each article so they can be output onto a map

		$map = App::make('CategoryResponder')->getCategoryMap($categoryId, $subChannelId);

		$retainedArticles = [];

		# work out which articles to keep based on the map result set
		foreach( $articles AS $article )
		{
			if( in_array($article['id'], $map->ids) )
			{
				$retainedArticles[] = $article;				
			}
		}

		return [
			'map' => $map->objects,
			'articles' => $retainedArticles,
			'totalArticles' => count($retainedArticles)
		];
	}
}