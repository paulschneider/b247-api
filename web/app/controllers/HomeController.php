<?php

Class HomeController extends ApiController {

    /**
    *  Main call to get the homepage response object
    */
    public function index()
    {
        return App::make('HomeResponseMaker')->make();
    }
}