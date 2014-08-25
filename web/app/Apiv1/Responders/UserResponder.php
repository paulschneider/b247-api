<?php namespace Apiv1\Responders;

use App;
use Lang;
use stdClass;
use Apiv1\Repositories\Users\User;

Class UserResponder {

	/**
	 * ensure we have all required fields for the current process
	 * 
	 * @param  array $requiredFields
	 * @param  array $form
	 * @return boolean 
	 */
	public function parameterCheck($requiredFields, $form)
	{
		if( aRequiredParameterIsMissing($requiredFields, $form) ) {
			return apiErrorResponse('insufficientArguments', ['public' => getMessage('public.insufficientParametersProvidedToContinue'), 'debug' => getMessage('api.insufficientParametersProvidedToContinue')]);
		}

		return true;
	}

	/** 
	 * authenticate a user account against provided form data
	 * @param  array $form
	 * @return User
	 */
	public function authenticate($form)
	{
		if( isApiResponse($result = App::make( 'SessionsResponseMaker' )->make( $form )) ) {
			return $result;
		}

		# we get the user back if its not an API response object
		$user = $result;

		return $user;
	}

	/**
	 * validate the form data supplied to ensure it meets our requirements
	 * 
	 * @param  Validator $validator [a validator instance against which to validate the supplied data]
	 * @param  array $form      	[form data]
	 * @return boolean            	[result]
	 */
	public function validate($validator, $form)
	{
		if( ! $validator->run( $form ) ) {
			return apiErrorResponse(  'unprocessable', [ 'errors' => $validator->errors(), 'debug' => getMessage('api.invalidFormData'), 'public' => getMessage('public.invalidFormData') ] );
		}

		return true;
	}

	/**
	 * retrieve and validate a user via their email address
	 * 
	 * @param  string $email
	 * @return User
	 */
	public function getUser($email)
	{
		# if we have an email address
		if( !empty( $email ) )
		{
			$validator = App::make( 'EmailValidator' );

			# check to see that we have a valid email address
			if( ! $validator->run( ['email' => $email] ))  {
				return apiErrorResponse(  'unprocessable', [ 'errors' => $validator->errors(), 'public' => getMessage('public.invalidFormData'), 'debug' => getMessage('api.invalidFormData') ] ); 
			}

			# try and find the user' account via the supplied email address
			if( ! $user = App::make( 'UserRepository' )->authenticate($email) ) {
				return apiErrorResponse(  'notFound', ['public' => getMessage('public.accountWithEmailAddressNotFound'), 'debug' => getMessage('api.accountWithEmailAddressNotFound')] ); 	
			}

			return App::make( 'UserTransformer' )->transform($user);
		}
	}

	/**
	 * using the provided access key header param, retrieve the user account and their profile
	 * 
	 * @param  string $accessKey [unique identifier for the user account]
	 * @return User
	 */
	public function getUserProfile($accessKey)
	{
		if( ! $user = App::make( 'UserRepository' )->getProfile($accessKey) ) {
			return apiErrorResponse(  'notFound', ['public' => getMessage('public.accessKeyNotProvided'), 'debug' => getMessage('api.noAccountWithThatAccessKey')] ); 	
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
			return apiErrorResponse( 'unauthorised', ['public' => getMessage('api.accessKeyNotProvided'), 'debug' => getMessage('api.accessKeyNotProvided')] );
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