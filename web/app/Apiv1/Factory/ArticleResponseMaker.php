<?php namespace Apiv1\Factory;

use App;
use Lang;

Class ArticleResponseMaker {

	var $category;
	var $channel; // sub-channel
	var $article;
	var $articleTransformer;
	var $articleRepository;

	/**
	 * User object
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user = null;

	public function __construct()
	{
		$this->articleRepository = App::make( 'ArticleRepository' );
		$this->articleTransformer = App::make( 'ArticleTransformer' );
		$this->articleTemplateTransformer = App::make( 'ArticleTemplateTransformer' );

		# see if we have an user accessKey present. If so we might want to show a different view of the homepage
        if( ! isApiResponse($user = App::make('UserResponder')->verify()) ) {
        	$this->user = $user;	
        }  
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
		# see if we can grab the category by the provided identifier
		if( isApiResponse($result = App::make( 'CategoryResponseMaker' )->getCategory( $this->category ))) {
			return $result;
		}

		# set the class category as the result of the previous call 
		$this->category = $result;

		# grab the channel
		if( isApiResponse($response = App::make( 'ChannelResponder' )->getChannel( $this->channel, $this->user )) )
		{
			return $response;
		}

		$this->channel = $response;

		# if we're trying to access a channel/category combination that is invalid then return an error
		if( ! categoryBelongsToChannel( $this->channel, $this->category ) ) {
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

	/**
	 * Retrieve the details of an article. All articles go through here when down to this level of the hierarchy
	 * 
	 * @return Apiv1\Repositories\Articles\Article
	 */
	public function getArticle()
	{		
		# grab the article from the ArticleResponder
		if( ! $this->article = App::make('Apiv1\Responders\ArticleResponder')->getArticle($this->channel, $this->category, $this->article)) {
			return apiErrorResponse('notFound', [ 'errorReason' => Lang::get('api.articleCouldNotBeLocated') ]);
		}

		return $this->article;
	}

	public function getRelatedArticles($article)
	{
		return $this->articleTransformer->transformCollection($this->articleRepository->getRelatedArticles($article, $this->user), ['ignorePlatform' => true]);
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