<?php namespace Api\Factory;

Class PasswordChangeResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	private $validator;
	private $form;
	private $user;
	private $userResponder;
	private $requiredFields = ['email', 'password', 'newPassword'];

	public function __construct()
	{
		$this->validator = \App::make( 'PasswordValidator' );
		$this->userResponder = \App::make( 'UserResponder' );
	}

	public function make($form)
	{
		$this->form = $form;

		if( isApiResponse( $result = $this->userResponder->parameterCheck($this->requiredFields, $this->form) ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->userResponder->authenticate($this->form) ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->userResponder->validate($this->validator, $this->form) ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->store() ) )
		{
			return $result;
		}

		return apiSuccessResponse( 'accepted', [$this->user] );
	}

	public function store()
	{
		$stored = \App::make( 'UserRepository' )->hashAndStore( $this->form['email'], $this->form['newPassword'] );

		if( ! $stored )
		{
			return apiErrorResponse(  'serverError', [ 'errorReason' => \Lang::get('api.recordCouldNotBeSaved') ] );
		}

		return true;
	}
}