<?php namespace Version1\Controllers;

use View;
use Input;
use Redirect;

class CategoryController extends ApiController {

    /**
    * display a list of existing categories
    *
    * @return View
    */
    public function show()
    {
        $categories = \Version1\Models\Category::all();

        return View::make('category.show', [ 'categories' => $categories ]);
    }

    /**
    * display a category creation form
    *
    * @return View
    */
    public function create($categoryId = null)
    {
        if( ! is_null($categoryId) )
        {
            $category = \Version1\Models\Category::find($categoryId);
        }
        else
        {
            $category = new \Version1\Models\Category();
        }

        $channels = makePathList(\Version1\Models\Channel::getChannelList());

        return View::make('category.create', [ 'category' => $category, 'channels' => $channels ]);
    }

    /**
    * store the details of a submitted category
    *
    * @return Redirect
    */
    public function store()
    {
        if( ! $category = \Version1\Models\Category::storeCategory(Input::all()) )
        {
            return $this->respondNotValid($category->errors);
        }
        else
        {
            return Redirect::to('category/list');
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
