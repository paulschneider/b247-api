<?php namespace Api\Factory;

Class ArticleResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	var $category;
	var $channel; // sub-channel
	var $article;
	var $controller;
	var $response = [];

	public function getChannel()
	{
		$this->category = \App::make( 'CategoryResponseMaker' )->getCategory( $this->category );
		$this->channel = \App::make( 'ChannelResponder' )->getChannel( $this->channel );

		if( ! categoryBelongsToChannel( $this->channel, $this->category ) )
		{
			return apiErrorResponse( 'notAcceptable' );
		}

		$this->response['channel'] = $this->channel;
	}

	public function getArticle()
	{
		$articleRepository = \App::make( 'ArticleRepository' );
		$articleTransformer = \App::make( 'ArticleTransformer' );
		
		if( ! $article = $articleRepository->getCategoryArticle( $this->channel, $this->category, $this->article ))
		{
			return \App::make( 'ApiResponder' )
				->setStatusCode(\Config::get('responsecodes.notFound.code'))
				->respondWithError(\Config::get('responsecodes.notFound.message'));
		}

		$article = $articleRepository->getCategoryArticle( $this->channel, $this->category, $this->article )->toArray();

		$this->response['article'] = $articleTransformer->transform( $article );
	}

	public function getAdverts()
	{
		$this->response['adverts'] = $this->getSponsors();
	}

	public function make($input, $controller)
	{ 	
		$this->channel = $input['channel'];
		$this->category = $input['category'];
		$this->article = $input['article'];
		$this->controller = $controller;

		// if it returns an API response then there's something wrong
		if( isApiResponse( $result = $this->getChannel()) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->getArticle() ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->getAdverts() ) )
		{
			return $result;
		}

		return $this->response;
	}
}