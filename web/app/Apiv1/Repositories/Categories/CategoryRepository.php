<?php namespace Apiv1\Repositories\Categories;

use Apiv1\Repositories\Categories\CategoryInterface;
use Apiv1\Repositories\Categories\Category;
use Apiv1\Repositories\Models\BaseModel;

Class CategoryRepository extends BaseModel {

    /**
    * Get a list of all available categories
    *
    * @var  ???
    */
    public function getAll()
    {
        return Category::all();
    }

    public function getCategory($categoryId)
    {
        return Category::find($categoryId);
    }

    public function getCategoryByIdentifier($category)
    {
        if( is_numeric($category) )
        {
            return $this->getCategory($category);
        }
        else
        {
            return Category::where('sef_name', $category)->first();
        }
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
