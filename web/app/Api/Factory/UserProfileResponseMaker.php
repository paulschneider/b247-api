<?php namespace Api\Factory;

use App;

Class UserProfileResponseMaker extends ApiResponseMaker implements ApiResponseMakerInterface {

	public function make($form)
	{
		// check to see if we have the accessKey header param. This is a helper function.
		if( ! userIsAuthenticated() )
		{
			return apiErrorResponse(  'unauthorised', ['errorReason' => "Required user access key not provided."] );
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