<?php namespace Apiv1\Factory;

use App;

Class ArticleResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	var $category;
	var $channel; // sub-channel
	var $article;
	var $articleRepository;
	var $articleTransformer;

	public function __construct()
	{
		$this->articleRepository = App::make( 'ArticleRepository' );
		$this->articleTransformer = App::make( 'ArticleTransformer' );
		$this->articleTransformer = App::make( 'ArticleTransformer' );
		$this->articleTemplateTransformer = App::make( 'ArticleTemplateTransformer' );
	}

	public function make($input)
	{ 	
		$this->channel = $input['subchannel'];
		$this->category = $input['category'];
		$this->article = $input['article'];

		if( isApiResponse( $result = $this->getChannel()) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->getAdverts() ) )
		{
			return $result;
		}	

		if( isApiResponse( $result = $this->getArticle() ) )
		{
			return $result;
		}

		$response = [
			'channel' => $this->channel,
			'adverts' => $this->getAdverts(),
			'article' => $this->articleTemplateTransformer->transform( $this->article->toArray() ),
			'related' => $this->getRelatedArticles($this->article),
			'navigation' => $this->nextPreviousArticles(),
		];

		// we return this differently to everywhere else because there is two ways of calling this class
		return $response;
	}

	public function getChannel()
	{
		if( isApiResponse($result = \App::make( 'CategoryResponseMaker' )->getCategory( $this->category )))
		{
			return $result;
		}

		$this->category = $result;

		$this->channel = \App::make( 'ChannelResponder' )->getChannel( $this->channel );

		if( ! categoryBelongsToChannel( $this->channel, $this->category ) )
		{
			return apiErrorResponse( 'notAcceptable' );
		}

		// remove all other categories except the one requested
		foreach( $this->channel['subChannels'][0]['categories'] AS $key => $category )
		{
			if( $category['id'] == $this->category['id'] )
			{
				$this->channel['subChannels'][0]['categories'] = [$category];
			}
		}

		return $this->channel;
	}

	public function getArticle()
	{		
		if( ! $article = $this->articleRepository->getCategoryArticle( $this->channel, $this->category, $this->article ))
		{
			return apiErrorResponse('notFound', []);
		}

		$this->article = $article;		

		return $this->article;
	}

	public function getRelatedArticles($article)
	{
		return $this->articleTransformer->transformCollection($this->articleRepository->getRelatedArticles($article), ['ignorePlatform' => true]);
	}

	public function getAdverts()
	{
		return $this->getSponsors();
	}

	public function nextPreviousArticles()
	{
		$articles = $this->articleRepository->getNextAndPreviousArticles($this->article);
		
		$articleNavigationTransformer = App::make('ArticleNavigationTransformer');	

		return [
			'previous' => $articleNavigationTransformer->transform($articles['previous']),
			'next' => $articleNavigationTransformer->transform($articles['next'])
		];
	}

	public function getRequiredArticleData($article)
	{
		return $this->articleTemplateTransformer->extract($article);
	}
}