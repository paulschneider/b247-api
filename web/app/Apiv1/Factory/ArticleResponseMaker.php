<?php namespace Apiv1\Factory;

use App;
use Lang;

Class ArticleResponseMaker {

	var $category;
	var $channel; // sub-channel
	var $article;
	var $articleTransformer;
	var $articleRepository;

	public function __construct()
	{
		$this->articleRepository = App::make( 'ArticleRepository' );
		$this->articleTransformer = App::make( 'ArticleTransformer' );
		$this->articleTemplateTransformer = App::make( 'ArticleTemplateTransformer' );
	}

	public function make($input)
	{ 	
		$this->channel = $input['subchannel'];
		$this->category = $input['category'];
		$this->article = $input['article'];

		# Get the details of the channel. Return an API response if not found
		if( isApiResponse( $result = $this->getChannel()) ) {
			return $result;
		}

		# Get the article. Return an API response if not found
		if( isApiResponse( $result = $this->getArticle() ) ) {
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
		if( isApiResponse($result = App::make( 'CategoryResponseMaker' )->getCategory( $this->category )))
		{
			return $result;
		}

		$this->category = $result;

		$this->channel = App::make( 'ChannelResponder' )->getChannel( $this->channel );

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
		if( ! $this->article = App::make('Apiv1\Responders\ArticleResponder')->getArticle($this->channel, $this->category, $this->article))
		{
			return apiErrorResponse('notFound', [ 'errorReason' => Lang::get('api.articleCouldNotBeLocated') ]);
		}

		return $this->article;
	}

	public function getRelatedArticles($article)
	{
		return $this->articleTransformer->transformCollection($this->articleRepository->getRelatedArticles($article), ['ignorePlatform' => true]);
	}

	public function getAdverts()
	{
		$sponsorResponder = App::make('SponsorResponder');
		$sponsorResponder->channel = $this->channel;
		$sponsorResponder->category = $this->category;

		return $sponsorResponder->getCategorySponsors(3);
	}

	public function nextPreviousArticles()
	{
		$articles = App::make( 'ArticleRepository' )->getNextAndPreviousArticles($this->article);
		
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