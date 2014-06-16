<?php

use Api\Transformers\ArticleTransformer;
use Version1\Articles\ArticleRepository;
use Version1\Articles\Article;
use Version1\Channels\ChannelRepository;
use Version1\Categories\CategoryRepository;
use Version1\Events\EventRepository;
use Version1\Models\DisplayStyle;

Class ArticleController extends ApiController {

    /**
    *
    * @var Api\Transformers\ArticleTransformer
    */
    protected $articleTransformer;

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

    public function __construct(
        ArticleTransformer $articleTransformer
        , ArticleRepository $articleRepository
        , ChannelRepository $channelRepository
        , CategoryRepository $categoryRepository
        , EventRepository $eventRepository
    )
    {
        $this->articleTransformer = $articleTransformer;
        $this->articleRepository = $articleRepository;
        $this->channelRepository = $channelRepository;
        $this->categoryRepository = $categoryRepository;
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $articles = $this->articleRepository->getArticles();

        return View::make('article.show', compact('articles'));
    }

    public function create()
    {
        $article = new Article();

        $channels = $this->channelRepository->getSimpleChannels();
        $subChannels = $this->channelRepository->getSimpleSubChannels();
        $categories = $this->categoryRepository->getSimpleCategories();
        $events = $this->eventRepository->getSimpleEvents();
        $types = $this->articleRepository->getArticleTypes();
        $displayStyles = DisplayStyle::getSimpleDisplayStyles();

        return View::make('article.create', compact('channels', 'subChannels', 'categories', 'article', 'events', 'types', 'displayStyles'));
    }

    public function show($identifier = null)
    {
        return $this->articleTransformer->transform($this->articleRepository->getArticle($identifier));
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
        $types = $this->articleRepository->getArticleTypes();
        $displayStyles = DisplayStyle::getSimpleDisplayStyles();

        return View::make('article.create', compact('channels', 'subChannels', 'categories', 'article', 'events', 'types', 'displayStyles'));
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
