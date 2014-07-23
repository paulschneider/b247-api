<?php namespace Api\Factory;

use App;

Class ArticleResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	var $category;
	var $channel; // sub-channel
	var $article;
	var $response = [];

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
			if( $category['id'] != $this->category['id'] )
			{
				unset($this->channel['subChannels'][0]['categories'][$key]);
			}
		}

		$this->response['channel'] = $this->channel;
	}

	public function getArticle()
	{
		$articleRepository = \App::make( 'ArticleRepository' );
		$articleTransformer = \App::make( 'ArticleTransformer' );
		
		if( ! $article = $articleRepository->getCategoryArticle( $this->channel, $this->category, $this->article ))
		{
			return apiErrorResponse('notFound', []);
		}

		$article = $articleRepository->getCategoryArticle( $this->channel, $this->category, $this->article );

		$this->article = $article;

		$related = $articleRepository->getRelatedArticles($this->article);

		$this->response['relatedArticles'] = $articleTransformer->transformCollection($related);

		$this->response['article'] = $articleTransformer->transform( $article->toArray(), [ 'showBody' => true ] );
	}

	public function getAdverts()
	{
		$this->response['adverts'] = $this->getSponsors();
	}

	public function nextPreviousArticles()
	{
		$articles = \App::make( 'ArticleRepository' )->getNextAndPreviousArticles($this->article);
		
		$articleNavigationTransformer = App::make('ArticleNavigationTransformer');	

		$this->response['previousArticle'] = $articleNavigationTransformer->transform($articles['previous']);
		$this->response['nextArticle'] = $articleNavigationTransformer->transform($articles['next']);
	}

	public function make($input)
	{ 	
		$this->channel = $input['subchannel'];
		$this->category = $input['category'];
		$this->article = $input['article'];

		// if it returns an API response then there's something wrong
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

		$this->nextPreviousArticles();			

		// we return this differently to everywhere else because there is two ways of calling this class
		return $this->response;
	}
}