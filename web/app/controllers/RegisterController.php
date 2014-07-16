<?php

use Api\Factory\RegistrationResponseMaker;

class RegisterController extends ApiController {

	public $validator;

	public function __construct(RegistrationResponseMaker $responseMaker)
	{
		$this->responseMaker = $responseMaker;
	}

	public function createSubscriber()
	{
		if( isApiResponse( $result = $this->responseMaker->make(Input::all()) ) )
		{
			return $result;
		}

		return apiSuccessResponse( 'created', $result );		
	}
}
