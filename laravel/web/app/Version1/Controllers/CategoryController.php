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
    public function index()
    {
        $categories = \Version1\Models\Category::all();

        return View::make('category.show', [ 'categories' => $categories ]);
    }

    public function show()
    {

    }

    /**
    * display a category creation form
    *
    * @return View
    */
    public function create()
    {
        $category = new \Version1\Models\Category();
        $channels = makePathList(\Version1\Models\Channel::getChannelList());

        return View::make('category.create', [ 'category' => $category, 'channels' => $channels ]);
    }

    public function edit($categoryId = null)
    {
        if( ! is_null($categoryId) and is_numeric($categoryId) )
        {
            $category = \Version1\Models\Category::find($categoryId);
        }
        else
        {
            return $this->respondNotValid('Invalid or missing category identifier.');
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
            return Redirect::to('category');
        }
    }
}
