<?php namespace Apiv1\Responders;

use App;
use Lang;
use stdClass;
use Version1\Users\User;

Class UserResponder {

	public function parameterCheck($requiredFields, $form)
	{
		if( aRequiredParameterIsMissing($requiredFields, $form) )
		{
			return apiErrorResponse('insufficientArguments', ['errorReason' => Lang::get('api.insufficientParametersProvidedToContinue')]);
		}

		return true;
	}

	public function authenticate($form)
	{
		if( isApiResponse($result = App::make( 'SessionsResponseMaker' )->make( $form )) )
		{
			return $result;
		}

		return $result;
	}

	public function validate($validator, $form)
	{
		if( ! $validator->run( $form ) )
		{
			return apiErrorResponse(  'unprocessable', $validator->errors() );
		}

		return true;
	}

	public function getUser($email)
	{
		if( !empty( $email ) )
		{
			$validator = App::make( 'EmailValidator' );

			if( ! $validator->run( ['email' => $email] )) 
			{
				return apiErrorResponse(  'unprocessable', $validator->errors() ); 
			}

			if( ! $user = App::make( 'UserRepository' )->authenticate($email) )
			{
				return apiErrorResponse(  'notFound', [ 'errorReason' => "User email address not found." ] ); 	
			}

			return App::make( 'UserTransformer' )->transform($user);
		}
	}

	public function getUserProfile($accessKey)
	{
		$userRepository = App::make( 'UserRepository' );

		$user = $userRepository->getProfile($accessKey);

		if( ! $user )
		{
			return apiErrorResponse(  'notFound', [ 'errorReason' => Lang::get('api.noAccountWithThatAccessKey') ] ); 	
		}
		
		return $user;
	}

	public function setUserContentPreferences(User $user, stdClass $data)
	{
		App::make( 'UserRepository' )->setContentPreferences($user, $data);
		
		return true;
	}
}