<?php namespace Apiv1\Responders;

use App;

Class ArticleResponder {

	/**
	 * Get an article
	 * 
	 * @param  array $subChannel [channel details]
	 * @param  array $category   [category details]
	 * @param  int $article    [unique identifier for the article]
	 * 
	 * @return Apiv1\Repositories\Articles\Article
	 */
	public function getArticle($channel, $category, $article)
	{
		return App::make( 'ArticleRepository' )->getCategoryArticle( $channel, $category, $article );
	}
}