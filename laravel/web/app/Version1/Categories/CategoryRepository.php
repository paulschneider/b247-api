<?php namespace Version1\Categories;

use \Version1\Categories\CategoryInterface;
use \Version1\Categories\Category;

Class CategoryRepository implements CategoryInterface {

    /**
    * Get a list of all available categories
    *
    * @var  ???
    */
    public function getAll()
    {
        return Category::all();
    }

    public function getCategory($categoryid)
    {
        return Category::find($categoryId);
    }

    /**
    * get a simple array containing categories and their ID's
    *
    * @var  ???
    */
    public function getSimpleCategories()
    {
        return Category::active()->alive()->lists('name', 'id');
    }

    /**
    * store the details of a category in the DB
    *
    * @var  ???
    */
    public function storeCategory($form)
    {
        if( !empty($form['id']) )
        {
            $category = Category::find($form['id']);
        }
        else
        {
            $category = new Category();
        }

        $category->name = $form['name'];
        $category->sef_name = safename($form['name']);
        $category->is_active = $form['is_active'];

        $category->save();

        return $category;
    }
}
