<?php namespace Apiv1\Factory;

use Lang;
use App;

Class UserPreferencesResponseMaker {

	protected $requiredFields = ['channels'];

	public function make( $data )
	{ 
		# check that we have everything need to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		if( isApiResponse($response = App::make('UserResponder')->verify()) )
		{
			return $response;
		}

		# we get the user back if everything went okay
		$user = $response;

		// sort the provided data into channels and categories
		$data = App::make( 'UserPreferenceOrganiser' )->organise($user, $data);

		// Update the database with the preferences of the specified user
		$userResponder->setUserContentPreferences($user, $data);

		// return a successful response
		return apiSuccessResponse( 'ok', ['furtherInfo' => Lang::get('api.userPreferencesUpdated')] );
	}
}