<?php namespace Apiv1\Factory;

use App;
use Lang;

Class UserProfileResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

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
}