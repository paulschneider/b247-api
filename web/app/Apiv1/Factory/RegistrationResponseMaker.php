<?php namespace Apiv1\Factory;

use App;
use Lang;
use Apiv1\Validators\RegistrationValidator;
use Apiv1\Mail\Newsletters\NewsletterList;
use Apiv1\Mail\Notifications\NewAccountRegistrationEmail;

Class RegistrationResponseMaker {

	/**
	 * @var array $form
	 */
	public $form;

	/**
	 * @var User $user
	 */
	public $user;

	/**
	 * @var NewsletterList $newsLetter
	 */
	protected $newsLetter;

	/**
	 * @var NewAccountRegistrationEmail $registrationEmail
	 */
	protected $registrationEmail;

	public function __construct(RegistrationValidator $validator, NewsletterList $newsletterList, NewAccountRegistrationEmail $registrationEmail)
	{
		$this->validator = $validator;
		$this->newsletter = $newsletterList;
		$this->registration = $registrationEmail;
	}

	public function validate()
	{
		if( ! $this->validator->run($this->form) ) 
		{
			return apiErrorResponse(  'unprocessable', $this->validator->errors() );
		}
		
		return true;
	}

	public function register()
	{
		if( ! $this->user = App::make( 'UserRepository' )->create($this->form) )
		{
			return apiErrorResponse(  'serverError', [ 'errorReason' => Lang::get('api.recordCouldNotBeSaved') ] );
		}
	}

	public function make($form)
	{
		$this->form = $form;

		if( isApiResponse( $result = $this->validate() ) )
		{
			return $result;
		}

		if( isApiResponse( $result = $this->register() ) )
		{
			return $result;
		}		

		$response = [
			'user' => App::make( 'UserTransformer' )->transform($this->user)			
		];

		// register the user to receive the newsletter
		 $this->newsletter->subscribeTo('daily-digest', $response['user']['email']);

		 // send out welcome email
		$this->registration->notify( ['user' => $response['user'], 'plainPassword' => $this->user->plain_pass] );

		return $response;
	}
}