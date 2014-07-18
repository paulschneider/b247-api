<?php

use Api\Factory\SessionsResponseMaker;

Class SessionsController extends ApiController {

	public $responseMaker;

	public function __construct(SessionsResponseMaker $responseMaker)
	{
		$this->responseMaker = $responseMaker;
	}

	public function login()
	{
		if( isApiResponse( $result = $this->responseMaker->make(Input::all()) ) )
		{
			return $result;
		}

		return apiSuccessResponse( 'accepted', $result );				
	}
}