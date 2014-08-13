<?php namespace Apiv1\Factory;

use App;
use Lang;

Class UserProfileResponseMaker {

	/**
	 * the fields required for these processes
	 * @var array
	 */
	public $requiredFields = [];

	public function make($form)
	{
		// check to see if we have the accessKey header param. This is a helper function.
		if( ! userIsAuthenticated() )
		{
			return apiErrorResponse(  'unauthorised', ['errorReason' => Lang::get('api.accessKeyNotProvided')] );
		}

		$accessKey = getAccessKey();				

		if( isApiResponse( $result = App::make( 'UserProfileMaker' )->make($form, $accessKey) ) )
		{
			return $result;
		}
		
		// we now have an updated user record with profile
		$user = $result;

		return apiSuccessResponse( 'ok', [ 'user' => App::make('UserTransformer')->transform($user) ] );
	}

	/**
	 * return a user and user profile response
	 * 
	 * @return $response
	 */
	public function get()
	{
		# check that we have everything need to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		if( isApiResponse($response = App::make('UserResponder')->verify()) )
		{
			return $response;
		}

		# we get the user back if everything went okay
		$user = $response;

		# if we got to here then everything went okay and the user will get their promotional code
		return apiSuccessResponse( 'ok', ['user' => App::make('UserTransformer')->transform($user->toArray())]);
	}
}