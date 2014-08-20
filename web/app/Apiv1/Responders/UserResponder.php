<?php namespace Apiv1\Responders;

use App;
use Lang;
use stdClass;
use Apiv1\Repositories\Users\User;

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
		if( ! $user = App::make( 'UserRepository' )->getProfile($accessKey) ) {
			return apiErrorResponse(  'notFound', [ 'errorReason' => Lang::get('api.noAccountWithThatAccessKey'), 'accessKey' => $accessKey ] ); 	
		}

		return $user;
	}

	/**
	 * Verify that we have everything we need to continue with an authenticated POST process
	 * 
	 * @param  array $requiredFields [a list of fields that a given process must receive]
	 * @param  array $form           [form values as provided by the client application]
	 * @return mixed                 [$user on success, API response on failure]
	 * 
	 */
	public function verify($requiredFields = [], $form = [])
	{
		# check to see if we have the accessKey header param. This is a helper function.
		if( ! userAccessKeyPresent() )
		{
			return apiErrorResponse(  'unauthorised', ['errorReason' => Lang::get('api.accessKeyNotProvided')] );
		}

		# check to make sure we have all the fields required to complete the process
		if( isApiResponse( $result = $this->parameterCheck($requiredFields, $form) ) )
		{
			# not all of the required fields were supplied
			return $result;
		}

		$accessKey = getAccessKey();

		# okay we have everything we need. Now get the user
		if( isApiResponse( $result = $this->getUserProfile($accessKey) ) )
		{
			# we couldn't find the user with the accessKey provided
			return $result;
		}

		# just so you know what we're returning if we get to here
		$user = $result;

		return $user;
	}
}