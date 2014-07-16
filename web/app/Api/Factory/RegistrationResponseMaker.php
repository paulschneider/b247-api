<?php namespace Api\Factory;

use Api\Validators\RegistrationValidator;

Class RegistrationResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	public $form;
	public $user;

	public function __construct(RegistrationValidator $validator)
	{
		$this->validator = $validator;
	}

	public function validate()
	{
		if( ! $this->validator->run($this->form) ) 
		{
			return apiErrorResponse(  'unprocessable', $this->validator->errors() );
		}
		
		return true;
	}

	public function register()
	{
		if( ! $this->user = \App::make( 'UserRepository' )->create($this->form) )
		{
			return apiErrorResponse(  'serverError', [ 'errorReason' => \Lang::get('api.recordCouldNotBeSaved') ] );
		}
	}

	public function make($form)
	{
		$this->form = $form;

		if( isApiResponse( $result = $this->validate() ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->register() ) )
		{
			return $result;
		}

		// todo
		// send out welcome email

		$response = [
			'user' => \App::make( 'UserTransformer' )->transform($this->user)			
		];

		// this should be removed before production deployment
		if( \App::environment() != 'production' )
		{
			$response['password'] = $this->user->plain_pass;
		}

		return $response;
	}
}