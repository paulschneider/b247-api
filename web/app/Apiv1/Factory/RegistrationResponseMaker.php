<?php namespace Apiv1\Factory;

use App;
use Lang;
use Apiv1\Validators\RegistrationValidator;

Class RegistrationResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	public $form;
	public $user;

	public function __construct(RegistrationValidator $validator)
	{
		$this->validator = $validator;
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

		// send out welcome email
		$mailClient = App::make('MailClient')->request('Apiv1\Mail\RegistrationEmail', ['user' => $response['user'], 'plainPassword' => $this->user->plain_pass] );

		return $response;
	}
}