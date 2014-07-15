<?php namespace Api\Factory;

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
			return \App::make( 'ApiResponder' )
				->setStatusCode(\Config::get('responsecodes.notFound.code'))
				->respondWithError(\Config::get('responsecodes.notFound.message'));
		}

		$article = $articleRepository->getCategoryArticle( $this->channel, $this->category, $this->article )->toArray();

		$this->response['article'] = $articleTransformer->transform( $article, [ 'showBody' => true ] );
	}

	public function getAdverts()
	{
		$this->response['adverts'] = $this->getSponsors();
	}

	public function make($input)
	{ 	
		$this->channel = $input['channel'];
		$this->category = $input['category'];
		$this->article = $input['article'];

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