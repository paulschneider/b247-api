<?php namespace Api\Factory;

use Api\Validators\PasswordValidator;

Class PasswordChangeResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	private $validator;
	private $form;
	private $user;

	public function __construct(PasswordValidator $validator)
	{
		$this->validator = $validator;
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

		$processes = [
			$this->authenticate(),
			$this->validate(),
			$this->store()
		];

		foreach( $processes AS $process )
		{
			if( isApiResponse( $process ))
			{
				return $process;
			}
		}

		return apiSuccessResponse( 'accepted', [$this->user] );
	}

}