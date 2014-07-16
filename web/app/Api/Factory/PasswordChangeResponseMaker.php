<?php namespace Api\Factory;

use Api\Validators\PasswordValidator;

Class PasswordChangeResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	private $validator;
	private $form;
	private $user;
	private $requiredFields = ['email', 'password', 'accessKey', 'newPassword'];

	public function __construct(PasswordValidator $validator)
	{
		$this->validator = $validator;
	}

	public function parameterCheck()
	{
		if( aRequiredParameterIsMissing($this->requiredFields, $this->form) )
		{
			return apiErrorResponse('insufficientArguments');
		}

		return true;
	}

	public function authenticate()
	{
		if( isApiResponse($result = \App::make( 'SessionsResponseMaker' )->make( $this->form )) )
		{
			return $result;
		}

		$this->user = $result;
	}

	public function validate()
	{
		if( ! $this->validator->validate( $this->form ) )
		{
			return apiErrorResponse(  'unprocessable', $this->validator->errors() );
		}

		return true;
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

	public function make($form)
	{
		$this->form = $form;

		if( isApiResponse( $result = $this->parameterCheck() ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->authenticate() ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->validate() ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->store() ) )
		{
			return $result;
		}

		return apiSuccessResponse( 'accepted', [$this->user] );
	}

}