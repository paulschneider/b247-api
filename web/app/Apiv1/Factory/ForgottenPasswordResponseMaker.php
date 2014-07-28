<?php namespace Apiv1\Factory;

Class ForgottenPasswordResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	private $validator;
	private $form;
	private $user;
	private $userResponder;
	private $requiredFields = ['email'];
	private $newPassword;

	public function __construct()
	{
		$this->validator = \App::make('PasswordValidator');
		$this->userResponder = \App::make( 'UserResponder' );
	}

	public function make($form)
	{
		$this->form = $form;

		if( isApiResponse( $result = $this->userResponder->parameterCheck($this->requiredFields, $this->form) ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->userResponder->getUser($this->form['email']) ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->store() ) )
		{
			return $result;
		}

		return apiSuccessResponse( 'accepted', [ 'newPassword' => $this->newPassword ] );
	}

	public function store()
	{
		$password = \App::make( 'UserRepository' )->generateAndStore( $this->form['email'] );

		if( ! $password )
		{
			return apiErrorResponse(  'serverError', [ 'errorReason' => \Lang::get('api.recordCouldNotBeSaved') ] );
		}

		$this->newPassword = $password;

		return true;
	}
}