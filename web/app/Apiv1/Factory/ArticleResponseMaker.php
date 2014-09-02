<?php namespace Apiv1\Factory;

use App;
use Lang;
use Config;

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

		$ads = $this->getAdverts();

		$response = [
			'channel' => $this->channel,
			'adverts' => $ads->sponsors,
			'fullPage' => $ads->fullPage,
			'article' => $this->articleTemplateTransformer->transform( $this->article->toArray() ),
			'related' => $this->getRelatedArticles($this->article),
			'navigation' => $this->nextPreviousArticles(),
		];

		# we return this differently to everywhere else because there are two ways of calling this class
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

	/**
	 * get some adverts to display on the article page
	 * 
	 * @return stdClass [sponsors && fullPage]
	 */
	public function getAdverts()
	{
		$sponsorResponder = App::make('SponsorResponder');
		$sponsorResponder->channel = $this->channel;
		$sponsorResponder->category = $this->category;

		return $sponsorResponder->setSponsorType(Config::get('global.sponsorLETTERBOX'))->getCategorySponsors(3);
	}

	/**
	 * when viewing an article there are next/previous controls to navigate through the categories
	 * articles. This works out which should be applied to each control
	 * 
	 * @return array
	 */
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

	/**
	 * ignoring all article classification, retrieve an article just by an identifier
	 * 
	 * @param  int || string $identifier [unique identifier of the article. ID or sef_name from the article table]
	 * @return ApiResponse
	 */
	public function getStaticArticle($identifier)
	{	
		# grab the article by its identifer
		$article = $this->articleRepository->getArticleByIdentifier($identifier['article']);

		# if we didn't get anything back then return an error
		if( ! $article) {
			return apiErrorResponse( 'notFound', ['public' => getMessage('public.staticArticleNotFound'), 'debug' => getMessage('api.staticArticleNotFound')] );
		}

		# if we found the article transform it into the required API response
		$article = App::make('Apiv1\Transformers\StaticArticleTransformer')->transform($article->toArray());

		# ... and return it!
		return apiSuccessResponse('ok', [ 'article' => $article]);
	}
}