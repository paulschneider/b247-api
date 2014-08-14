<?php

Class AppNavigationController extends ApiController {	

	public function index()
	{
        return apiSuccessResponse( 'ok', App::make('AppNavResponseMaker')->make() );
	}

}