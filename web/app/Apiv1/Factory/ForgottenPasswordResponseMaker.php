<?php namespace Apiv1\Factory;

use App;
use Lang;

Class ForgottenPasswordResponseMaker {

	private $validator;
	private $form;
	private $user;
	private $userResponder;
	private $requiredFields = ['email'];
	private $newPassword;

	/**
	 * @var $passwordNotifier
	 */
	protected $passwordNotifier;

	public function __construct()
	{
		$this->validator = App::make('PasswordValidator');
		$this->userResponder = App::make( 'UserResponder' );

		$this->passwordNotifier = App::make('Apiv1\Mail\Notifications\ForgottenPasswordEmail');
	}

	public function make($form)
	{
		$this->form = $form;

		if( isApiResponse($result = $this->userResponder->parameterCheck($this->requiredFields, $this->form)) ) {
			return $result;
		}

		if( isApiResponse($result = $this->userResponder->getUser($this->form['email'])) ) {
			return $result;
		}

		if( isApiResponse( $result = $this->store()) ) {
			return $result;
		}

		# send out the forgotten password email
		$this->passwordNotifier->notify( ['email' => $this->form['email'], 'password' => $this->newPassword] );

		return apiSuccessResponse( 'accepted', ['public' => getMessage('public.forgottenPasswordReminderSent'), 'debug' => getMessage('api.forgottenPasswordReminderSent')] );
	}

	public function store()
	{
		$password = App::make( 'UserRepository' )->generateAndStore( $this->form['email'] );

		if( ! $password ) {
			return apiErrorResponse( 'serverError', ['public' => getMessage('public.passwordCouldNotBeUpdated'), 'debug' => getMessage('api.passwordCouldNotBeUpdated')] );
		}

		$this->newPassword = $password;

		return true;
	}
}