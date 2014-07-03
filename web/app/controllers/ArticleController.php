<?php

use Api\Transformers\ArticleTransformer;
use Api\Transformers\SponsorTransformer;

use Api\Factory\PatternMaker;
use Version1\Models\DisplayType;
use Version1\Articles\Article;
use Version1\Articles\Toolbox;
use Api\Factory\ChannelFeed;

use Version1\Articles\ArticleRepository;
use Version1\Channels\ChannelRepository;
use Version1\Categories\CategoryRepository;
use Version1\Events\EventRepository;
use Version1\Sponsors\SponsorRepository;

Class ArticleController extends ApiController {

    /**
    *
    * @var Api\Transformers\ArticleTransformer
    */
    protected $articleTransformer;

    /**
    *
    * @var Api\Transformers\SponsorTransformer
    */
    protected $sponsorTransformer;

    /**
    *
    * @var Version1\Articles\ArticleRepository
    */
    protected $articleRepository;

    /**
    *
    * @var Version1\Channels\ChannelRepository
    */
    protected $channelRepository;

    /**
    *
    * @var Version1\Categories\CategoryRepository
    */
    protected $categoryRepository;

    /**
    *
    * @var Version1\Events\EventRepository
    */
    protected $eventRepository;

    /**
    *
    * @var Version1\Sponsors\SponsorRepository
    */
    protected $sponsorRepository;

    /**
    *
    * @var Api\Factory\PatternMaker
    */
    protected $patternMaker;

    public function __construct(
        ArticleTransformer $articleTransformer
        , ArticleRepository $articleRepository
        , ChannelRepository $channelRepository
        , CategoryRepository $categoryRepository
        , EventRepository $eventRepository
        , SponsorRepository $sponsorRepository
        , SponsorTransformer $sponsorTransformer
    )
    {
        $this->articleTransformer = $articleTransformer;
        $this->articleRepository = $articleRepository;
        $this->channelRepository = $channelRepository;
        $this->categoryRepository = $categoryRepository;
        $this->eventRepository = $eventRepository;
        $this->sponsorRepository = $sponsorRepository;
        $this->sponsorTransformer = $sponsorTransformer;
    }

    public function index()
    {
        $articles = $this->articleRepository->getArticles(null, 1000);

        return View::make('article.show', compact('articles'));
    }

    public function create()
    {
        $article = new Article();

        $channels = $this->channelRepository->getSimpleChannels();
        $subChannels = $this->channelRepository->getSimpleSubChannels();
        $categories = $this->categoryRepository->getSimpleCategories();
        $events = $this->eventRepository->getSimpleEvents();

        return View::make('article.create', compact('channels', 'subChannels', 'categories', 'article', 'events'));
    }

    public function show($identifier = null)
    {
        // get some ads from the database
        $sponsors = $this->sponsorRepository->getSponsors();

        // Get some more ads from the database which aren't any of the $sponsors ads
        $ads = $this->sponsorRepository->getWhereNotInCollection( $sponsors, 30 );

        // create a new instance of the pattern maker
        $this->patternMaker = new PatternMaker( 1 );

        // retrieve the details of the main article we want to show to the user
        if( ! $mainArticle = $this->articleRepository->getArticle( $identifier ) )
        {
            return $this->respondNoDataFound("No article found with supplied identifier.");
        }

        $recommendations = Toolbox::getRelatedArticles( $mainArticle, $this->articleRepository->getArticlesWhereNotInCollection( [ $mainArticle['id'] ] ) );

        $data = [
            'adverts' => $this->sponsorTransformer->transformCollection( $sponsors->toArray() ), 
            'article' => $this->articleTransformer->transform( $mainArticle ),
            'recommendations' => $this->patternMaker->make( [ 'articles' => $recommendations, 'sponsors' => $ads ] )->articles
        ]; 

        return $this->respondFound(Lang::get('api.articleFound'), $data);
    }

    public function edit($id = null)
    {
        if( ! is_numeric($id) )
        {
            return $this->respondNotValid('Invalid articled identifier supplied.');
        }

        $article = $this->articleRepository->getArticle($id);

        $channels = $this->channelRepository->getSimpleChannels();
        $subChannels = $this->channelRepository->getSimpleSubChannels();
        $categories = $this->categoryRepository->getSimpleCategories();
        $events = $this->eventRepository->getSimpleEvents();

        return View::make('article.create', compact('channels', 'subChannels', 'categories', 'article', 'events'));
    }

    /**
     * Store a newly created / recently updated resource
     *
     * @return Response
     */
    public function store()
    { 
        if( ! $article = $this->articleRepository->storeArticle(Input::all()))
        {
            return $this->respondNotValid($article->errors);
        }
        else
        {
            return Redirect::to('article');
        }
    }

    /**
    * action on an UPDATE call to the resource
    *
    * @return ApiController Response
    */
    public function update()
    {
        return ApiController::respondNotAllowed();
    }

    /**
    * action on an UPDATE call to the resource
    *
    * @return ApiController Response
    */
    public function destroy()
    {
        return ApiController::respondNotAllowed();
    }
}
