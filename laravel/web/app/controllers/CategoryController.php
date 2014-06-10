<?php

use Version1\Categories\CategoryRepository;
use Version1\Categories\Category;
use Version1\Channels\ChannelRepository;

Class CategoryController extends ApiController {

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

    public function __construct(
        CategoryRepository $categoryRepository
        ,ChannelRepository $channelRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->channelRepository = $channelRepository;
    }

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
        $category = new Category();
        $channels = makePathList($this->channelRepository->getChannelList());

        return View::make('category.create', compact('category', 'channels'));
    }

    public function edit($categoryId = null)
    {
        if( ! is_null($categoryId) and is_numeric($categoryId) )
        {
            $category = $this->channelRepository->getCategory($categoryId);
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
