<?php namespace Api\Factory;

use Api\Validators\SessionsValidator;

Class SessionsResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	private $validator;
	private $form;
	private $user;

	public function __construct(SessionsValidator $validator)
	{
		$this->validator = $validator;
	}

	public function validate()
	{
		if( ! $this->form['email'] || ! $this->form['password'] )
		{
			return apiErrorResponse( 'insufficientArguments', [ 'errorReason' => Lang::get('api.loginWithInsufficientParams') ] );
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
			return apiErrorResponse( 'unauthorised' );					
		}

		$this->user = \App::make('UserTransformer')->transform( $user->toArray() );
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
}