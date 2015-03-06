<?php namespace Apiv1\Factory;

use App;
use Lang;

Class PasswordChangeResponseMaker {

	private $validator;
	private $form;
	private $user;
	private $userResponder;
	private $requiredFields = ['email', 'password', 'newPassword'];

	/**
	 * @var $passwordNotifier
	 */
	protected $passwordNotifier;

	public function __construct()
	{
		$this->userResponder = App::make('UserResponder');
		$this->validator = App::make( 'PasswordValidator' );
		$this->passwordNotifier = App::make('Apiv1\Mail\Notifications\AccountPasswordChangedEmail');
	}

	public function make($form)
	{
		$this->form = $form;

		# check that we have everything needed to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		
		$validator = App::make('Apiv1\Validators\PasswordChangeValidator');

		if( isApiResponse($result = $this->userResponder->validate($validator, $this->form)) ){
			return $result;
		}
		
		# auth the user against the provided credentials
		if( isApiResponse($response = $this->userResponder->authenticate($form)) ) {
			return $response;
		}

		$this->user = $response['user'];

		# store the new password in the database
		if( isApiResponse($result = $this->store()) ) {
			return $result;
		}

		# send out password updated email
		$this->passwordNotifier->notify( ['user' => $this->user, 'password' => $this->form['newPassword']] );

		# send the response back
		return apiSuccessResponse( 'accepted', ['user' => $this->user, 'public' => getMessage('public.userPasswordSuccessfullyUpdated'), 'debug' => getMessage('api.userPasswordSuccessfullyUpdated')] );
	}

	public function store()
	{
		$response = App::make( 'UserRepository' )->hashAndStore( $this->form['email'], $this->form['newPassword'] );

		if( ! $response ) {
			return apiErrorResponse( 'serverError', ['public' => getMessage('public.passwordCouldNotBeUpdated'), 'debug' => getMessage('api.passwordCouldNotBeUpdated')] );
		}

		$this->user['accessKey'] = $response->accessKey;

		return true;
	}
}