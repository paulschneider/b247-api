<?php namespace Version1\Controllers;

use Request;
use Response;
use Redirect;
use View;
use Input;
use \Api\Transformers\ArticleTransformer;

class ArticleController extends ApiController {

    /**
    *
    * @var Api\Transformers\ArticleTransformer
    */
    protected $articleTransformer;

    public function __construct(ArticleTransformer $articleTransformer)
    {
        $this->articleTransformer = $articleTransformer;
    }

    public function index()
    {
        $articles = \Version1\Models\Article::getArticles();
        return View::make('article.show', compact('articles', $articles));
    }

    public function create()
    {
        $article = new \Version1\Models\Article();

        $channels = \Version1\Models\Channel::getSimpleChannels();
        $subChannels = \Version1\Models\Channel::getSimpleSubChannels();
        $categories = \Version1\Models\Category::getSimpleCategories();

        return View::make('article.create', [ 'channels' => $channels, 'subChannels' => $subChannels, 'categories' => $categories, 'article' => $article ]);
    }

    public function show($identifier = null)
    {
        return $this->articleTransformer->transform(\Version1\Models\Article::getArticle($identifier));
    }

    public function edit($id = null)
    {
        if( ! is_null($id) and is_numeric($id) )
        {
            $article = \Version1\Models\Article::getArticle($id);
        }
        else
        {
            return $this->respondNotValid('Invalid articled identifier supplied.');
        }

        $channels = \Version1\Models\Channel::getSimpleChannels();
        $subChannels = \Version1\Models\Channel::getSimpleSubChannels();
        $categories = \Version1\Models\Category::getSimpleCategories();

        return View::make('article.create', [ 'channels' => $channels, 'subChannels' => $subChannels, 'categories' => $categories, 'article' => $article ]);
    }

    /**
     * Store a newly created / recently updated resource
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
