<?php

use Version1\Categories\Category;

Class CategoryController extends ApiController {

    var $responseMaker;

    /**
    * display a list of existing categories
    *
    * @return View
    */
    public function index()
    {
        $categories = $this->categoryRepository->getAll();

        return View::make('category.show', compact('categories'));
    }

    public function getCategoryArticles($categoryId = null)
    {   
        if( Input::get('subChannel') )
        {
            $channelId = Input::get('subChannel');

            $this->responseMaker = App::make('CategoryResponseMaker');

            if( ! $channel = $this->responseMaker->getChannel( $channelId ))
            {
                return $this->respondNoDataFound( Lang::get('api.channelNotFound') );
            }

            $this->response = $this->responseMaker->make($categoryId, $channel);

             return $this->respondFound(Lang::get('api.categoryFound'), $this->response);
        }
        // We won't be able to determine which category the caller wants
        else
        {
            return $this->respondWithInsufficientParameters(Lang::get('api.defaultRespondInsufficientParameters'));
        }
    }

    /**
    * display a category creation form
    *
    * @return View
    */
    public function create()
    {
        $category = new Category();
        $channels = makePathList($this->channelRepository->getChannelList());

        return View::make('category.create', compact('category', 'channels'));
    }

    public function edit($categoryId = null)
    {
        if( ! is_null($categoryId) and is_numeric($categoryId) )
        {
            $category = $this->categoryRepository->getCategory($categoryId);
        }
        else
        {
            return $this->respondNotValid('Invalid or missing category identifier.');
        }

        $channels = makePathList($this->channelRepository->getChannelList());
        return View::make('category.create', compact('category', 'channels'));
    }

    /**
    * store the details of a submitted category
    *
    * @return Redirect
    */
    public function store()
    {
        if( ! $category = $this->categoryRepository->storeCategory(Input::all()) )
        {
            return $this->respondNotValid($category->errors);
        }
        else
        {
            return Redirect::to('category');
        }
    }
}
