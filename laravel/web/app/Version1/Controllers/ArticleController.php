<?php namespace Version1\Controllers;

use Request;
use Response;
use View;
use Input;

class ArticleController extends ApiController {

    public function index($id)
    {
        return \Version1\Models\Article::getArticle($id);
    }

    public function create()
    {
        $channels = \Version1\Models\Channel::getSimpleChannels();
        $subChannels = \Version1\Models\Channel::getSimpleSubChannels();
        $categories = \Version1\Models\Category::getSimpleCategories();

        return View::make('article.create', [ 'channels' => $channels, 'subChannels' => $subChannels, 'categories' => $categories ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        return Input::all();
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
