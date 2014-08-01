<?php namespace Apiv1\Factory;

use App;
use Lang;

Class PasswordChangeResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	private $validator;
	private $form;
	private $user;
	private $userResponder;
	private $requiredFields = ['email', 'password', 'newPassword'];

	public function __construct()
	{
		$this->validator = App::make( 'PasswordValidator' );
		$this->userResponder = App::make( 'UserResponder' );
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

		$this->user = $result['user']; // the previous call returns a transformed user object

		if( isApiResponse( $result = $this->userResponder->validate($this->validator, $this->form) ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->store() ) )
		{
			return $result;
		}

		// send out password updated email
		$mailClient = App::make('MailClient')->request('Apiv1\Mail\AccountPasswordChangedEmail', ['user' => $this->user, 'password' => $this->form['newPassword']]);

		return apiSuccessResponse( 'accepted', $this->user );
	}

	public function store()
	{
		$userRepository = App::make( 'UserRepository' );

		$response = $userRepository->hashAndStore( $this->form['email'], $this->form['newPassword'] );

		if( ! $response )
		{
			return apiErrorResponse(  'serverError', [ 'errorReason' => Lang::get('api.recordCouldNotBeSaved') ] );
		}

		$this->user['accessKey'] = $response->accessKey;

		return true;
	}
}