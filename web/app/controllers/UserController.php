<?php

Class UserController extends BaseController {	

	/**
	 * Get all preferences for an authenticated user
	 * @return ApiResponse
	 */
	public function getPreferences()
	{
		return App::make('Apiv1\Factory\UserPreferenceResponseMaker')->get();
	}

	/**
	 * Set the preferences for an authenticated used
	 */
	public function setPreferences()
	{
		# a fault with the way the website sends large arrays causes the memory limit to be exceeded.
		# the website has been updated to send large preference arrays as json. This is handled below
		if(isset($_POST[0]))
		{
			# grab the json which will be at position zero
			$form = $_POST[0];	

			# decode it back into the array and set it into a var to be passed to set() below
			$input = json_decode($form, true);
		}
		else 
		{
			# otherwise just use the supplied array
			$input = Input::all();
		}
		
		return App::make('Apiv1\Factory\UserPreferenceResponseMaker')->set($input);
	}

	/**
	 * get a user and their profile
	 * 
	 * @return $response
	 */
	public function getUser()
	{
		return App::make( 'UserProfileResponseMaker' )->get();
	}

	/**
	 * Change a user password either by direct request as a forgotten reminder
	 * 
	 * @return $response
	 */
	public function changeUserPassword()
	{
		if( Input::get('forgotten') ) {
			return App::make( 'ForgottenPasswordResponseMaker' )->make(Input::all());	
		}
		else {
			return App::make( 'PasswordChangeResponseMaker' )->make(Input::all());	
		}
	}

	/**
	 * Create or update a user profile
	 * 
	 * @return $response
	 */
	public function profile()
	{
		return App::make( 'UserProfileResponseMaker' )->make(Input::all());
	}

	/**
	 * Update user content preferences 
	 * 
	 * @return $response
	 */
	public function preferences()
	{
		return App::make( 'UserPreferencesResponseMaker' )->make(Input::all());
	}

	/**
     * Redeem an article promotional code
     * 
     * @return mixed $response
     */
    public function redeemPromotion()
    {
        return App::make('Apiv1\Factory\ArticlePromotionRedemptionResponseMaker')->redeem(Input::all());
    }

    /**
     * Enter a user in to a competition
     * 
     * @return mixed $response
     */
    public function enterCompetition()
    {
        return App::make('Apiv1\Factory\CompetitionUserEntryResponseMaker')->enterUser(Input::all());
    }

    /**
     * process and store a list of user district preferences. These are geographical areas the user has promoted
     * and which affect the order of article content as produced by the API
     * 
     * @return API response [the result of the process]
     */
    public function districtPreferences()
    {
    	return App::make('Apiv1\Factory\UserDistrictPreferenceResponseMaker')->updateUserDistricts(Input::all());
    }
}