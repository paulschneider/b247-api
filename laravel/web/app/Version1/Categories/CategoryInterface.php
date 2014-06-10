<?php namespace Version1\Categories;

Interface CategoryInterface {

    public function getAll();

    public function getCategory($id);

    public function getSimpleCategories();

    public function storeCategory($form);
}
