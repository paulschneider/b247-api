<?php

Class AppNavigationController extends ApiController {

	public function index()
	{
        return apiSuccessResponse( 'contentLocated', App::make('AppNavResponseMaker')->make() );
	}

}