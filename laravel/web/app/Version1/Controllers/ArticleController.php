<?php namespace Version1\Controllers;

use Request;
use Response;
use View;
use Input;

class ArticleController extends ApiController {

    /**
    *
    * @var Api\Transformers\ArticleTransformer
    */
    protected $articleTransformer;

    public function __construct(\Api\Transformers\ArticleTransformer $articleTransformer)
    {
        $this->articleTransformer = $articleTransformer;
    }

    public function index($id)
    {
        return $this->articleTransformer->transform(\Version1\Models\Article::getArticle($id));
    }

    public function create($id = null)
    {
        if( ! is_null($id) )
        {
            $article = \Version1\Models\Article::getArticle($id);
        }
        else
        {
            $article = new \Version1\Models\Article();
        }

        $channels = \Version1\Models\Channel::getSimpleChannels();
        $subChannels = \Version1\Models\Channel::getSimpleSubChannels();
        $categories = \Version1\Models\Category::getSimpleCategories();

        return View::make('article.create', [ 'channels' => $channels, 'subChannels' => $subChannels, 'categories' => $categories, 'article' => $article ]);
    }

    public function show()
    {
        $articles = \Version1\Models\Article::getArticles();

        return View::make('article.show', compact('articles', $articles));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if( ! $article = \Version1\Models\Article::storeArticle(Input::all()) )
        {
            return $this->respondNotValid($article->errors);
        }
        else
        {
            return $this->respondCreated('Article successfully stored');
        }
    }

    /**
    * if a PUT request is made
    *
    * @return Response
    */
    public function putIndex()
    {
        return $this->respondNotAllowed();
    }

    /**
    * if a PATCH request is made
    *
    * @return Response
    */
    public function patchIndex()
    {
        return $this->respondNotAllowed();
    }

    /**
    * if a DELETE request is made
    *
    * @return Response
    */
    public function deleteIndex()
    {
        return $this->respondNotAllowed();
    }
}
