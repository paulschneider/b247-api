<?php namespace Api\Responders;

Class ChannelResponder {

	public function getArticles($channel)
	{	
		$articleRepository = \App::make('ArticleRepository');

		$type = getSubChannelType( $channel );
		$subChannelId = getSubChannelId($channel);		

		return $articleRepository->getArticles( $type, 25, $subChannelId, true ); 
	}

	public function getArticlesInRange($channel, $duration, $time)
	{
		$articleRepository = \App::make('ArticleRepository');

		$subChannelId = getSubChannelId($channel);

		return $articleRepository->getChannelListing( $subChannelId, 20, $duration, $time );
	}
}