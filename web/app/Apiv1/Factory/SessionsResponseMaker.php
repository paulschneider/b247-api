<?php namespace Apiv1\Factory;

use App;
use Hash;
use Lang;

Class SessionsResponseMaker {

	private $validator;
	private $form;
	private $user;

	public function __construct()
	{
		$this->validator = App::make( 'SessionsValidator' );
	}

	public function make($form)
	{
		$this->form = $form;

		# validate the form details to ensure they meet minimum requirements
		if( isApiResponse( $result = $this->validate() ) ) {
			return $result;
		}	

		# authenticate the user with the now validated form data
		if( isApiResponse( $result = $this->authenticate() ) ) {
			return $result;
		}

		return [
			'user' => $this->user
		];
	}

	public function validate()
	{
		if( ! isset($this->form['email']) || ! isset($this->form['password']) ) {
			return apiErrorResponse( 'insufficientArguments', [ 'public' => getMessage('public.loginWithInsufficientParams'), 'debug' => getMessage('api.loginWithInsufficientParams') ] );
		}

		if( ! $this->validator->run($this->form)) {
			return apiErrorResponse(  'unprocessable', ['errors' => $this->validator->errors()] );
		}
	}

	/**
	 * authenticate a user against provided form details
	 * 
	 * @return [type] [description]
	 */
	public function authenticate()
	{
		# grab the user account including password so we can check the details
		if( ! $user = App::make( 'UserRepository' )->authenticate($this->form['email']) ) {
			return apiErrorResponse( 'notFound', ['public' => getMessage('public.userAccountNotFound'), 'debug' => getMessage('api.userAccountNotFound')]);
		}

		# check the provided password with that stored
		if (! Hash::check($this->form['password'], $user->password)) {	
			return apiErrorResponse( 'unauthorised', [ 'public' => getMessage('public.userAccountPasswordMismatch'), 'debug' => getMessage('api.userAccountPasswordMismatch') ]  );					
		}

		# we got here so everything was fine. Now transform the user and make it available to the class
		$this->user = App::make('UserTransformer')->transform( $user->toArray() );
	}
}