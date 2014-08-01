<?php namespace Apiv1\Repositories\Articles;

Class Toolbox
{
	public static function getRelatedArticles( $source, $articles = [], $limit = 20 )
	{
		$subChannelId = $source['location'][0]['subChannelId'];
		$displayTypeId = $source['location'][0]['displayTypeId'];

		$related = [];
		$counter = 0;

		$articles = $articles->toArray();

		foreach( $articles AS $article )
		{
			if( isset( $article['location'][0] ) )
			{
				$articleLocation = $article['location'][0];

				if( $articleLocation['displayTypeId'] == $displayTypeId and $articleLocation['subChannelId'] == $subChannelId )
				{		
					$related[] = $article;
				}
			}
		}
		
		return $related;
	}
}