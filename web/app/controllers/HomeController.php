<?php

Class HomeController extends ApiController {

    var $responseMaker;

    /**
    *  Main call to get the homepage response object
    */
    public function index()
    {
        $this->responseMaker = App::make('HomeResponseMaker');

        if( userIsAuthenticated() )
        {
            return "user is authenticated";
        }

        $this->response = $this->responseMaker->make();

        return $this->respondFound(Lang::get('api.homepageFound'), $this->response);
    }
}
