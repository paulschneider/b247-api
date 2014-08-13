<?php namespace Apiv1\Factory;

use Lang;
use App;

Class UserPreferencesResponseMaker {

	protected $requiredFields = ['channels'];

	public function make( $data )
	{ 
		$userResponder = App::make( 'UserResponder' );

		// check to see if we have the accessKey header param. This is a helper function.
		if( ! userAccessKeyPresent() )
		{
			return apiErrorResponse(  'unauthorised', ['errorReason' => Lang::get('api.accessKeyNotProvided')] );
		}

		$accessKey = getAccessKey();

		// check to make sure we have all the fields required to complete the process
		if( isApiResponse( $result = $userResponder->parameterCheck($this->requiredFields, $data) ) )
		{
			// not all of the required fields were supplied
			return $result;
		}

		// okay we have everything we need. Now get the user
		if( isApiResponse( $result = $userResponder->getUserProfile($accessKey) ) )
		{
			// we couldn't find the user with the accessKey provided
			return $result;
		}

		$user = $result;

		// sort the provided data into channels and categories
		$data = App::make( 'UserPreferenceOrganiser' )->organise($user, $data);

		// Update the database with the preferences of the specified user
		$userResponder->setUserContentPreferences($user, $data);

		// return a successful response
		return apiSuccessResponse( 'ok', ['furtherInfo' => Lang::get('api.userPreferencesUpdated')] );
	}
}