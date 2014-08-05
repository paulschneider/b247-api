<?php namespace Apiv1\Factory;

Class SessionsResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	private $validator;
	private $form;
	private $user;

	public function __construct()
	{
		$this->validator = \App::make( 'SessionsValidator' );
	}

	public function make($form)
	{
		$this->form = $form;

		if( isApiResponse( $result = $this->validate() ) )
		{
			return $result;
		}	

		if( isApiResponse( $result = $this->authenticate() ) )
		{
			return $result;
		}

		return [
			'user' => $this->user
		];
	}

	public function validate()
	{
		if( ! isset($this->form['email']) || ! isset($this->form['password']) )
		{
			return apiErrorResponse( 'insufficientArguments', [ 'errorReason' => \Lang::get('api.loginWithInsufficientParams') ] );
		}

		if( ! $this->validator->run($this->form))
		{
			return apiErrorResponse(  'unprocessable', $this->validator->errors() );
		}
	}

	public function authenticate()
	{
		if( ! $user = \App::make( 'UserRepository' )->authenticate($this->form['email']) ) 
		{
			return apiErrorResponse( 'notFound' );
		}

		if (! \Hash::check($this->form['password'], $user->password))
		{	
			return apiErrorResponse( 'unauthorised', [ 'errorReason' => \Lang::get('api.userAccountPasswordMismatch') ]  );					
		}

		$this->user = \App::make('UserTransformer')->transform( $user->toArray() );
	}
}