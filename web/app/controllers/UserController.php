<?php

Class UserController extends BaseController {	

	public function getPreferences()
	{
		return App::make('Apiv1\Factory\UserPreferenceResponseMaker')->get();
	}

	public function setPreferences()
	{
		$form = json_decode('{"channels":[{"id":1,"name":"News and Comment","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"news-comment","colour":"#33b9f8","secondaryColour":"#222c5c","path":"/news-comment/","isEnabled":false,"subChannels":[{"id":4,"name":"Daily","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"daily","path":"/news-comment/daily/","displayType":{"id":1,"type":"Article"},"isEnabled":true,"categories":[{"id":1,"name":"Crime","sefName":"crime","path":"/news-comment/daily/crime/","isEnabled":true},{"id":2,"name":"Media","sefName":"media","path":"/news-comment/daily/media/","isEnabled":true},{"id":9,"name":"Politics","sefName":"politics","path":"/news-comment/daily/politics/","isEnabled":true},{"id":10,"name":"George Ferguson","sefName":"george_ferguson","path":"/news-comment/daily/george_ferguson/","isEnabled":true}]},{"id":5,"name":"Features","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"features","path":"/news-comment/features/","displayType":{"id":1,"type":"Article"},"isEnabled":true,"categories":[{"id":3,"name":"Health","sefName":"health","path":"/news-comment/features/health/","isEnabled":true},{"id":4,"name":"Environment","sefName":"environment","path":"/news-comment/features/environment/","isEnabled":true}]},{"id":10,"name":"Kevin\'s news","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"kevins_news","path":"/news-comment/kevins_news/","displayType":{"id":1,"type":"Article"},"isEnabled":true}]},{"id":2,"name":"Whats On","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"whats-on","colour":"#56cd6c","secondaryColour":"#295e4e","path":"/whats-on/","isEnabled":false,"subChannels":[{"id":6,"name":"Theatre","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"theatre","path":"/whats-on/theatre/","displayType":{"id":2,"type":"Listing"},"isEnabled":true,"categories":[{"id":5,"name":"Comedy","sefName":"comedy","path":"/whats-on/theatre/comedy/","isEnabled":true}]}]},{"id":3,"name":"Food and Drink","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"food-drink","colour":"#d6ab29","secondaryColour":"#7b473a","path":"/food-drink/","isEnabled":false,"subChannels":[{"id":7,"name":"Guide","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"guide","path":"/food-drink/guide/","displayType":{"id":3,"type":"Directory"},"isEnabled":true,"categories":[{"id":6,"name":"Italian","sefName":"italian","path":"/food-drink/guide/italian/","isEnabled":true}]},{"id":8,"name":"Offers and Competitions ","description":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.","sefName":"offers-competitions ","path":"/food-drink/offers-competitions/","displayType":{"id":4,"type":"Promotion"},"isEnabled":true,"categories":[{"id":7,"name":"Indian","sefName":"indian","path":"/food-drink/offers-competitions/indian/","isEnabled":true}]}]}],"districts":[{"id":4,"name":"East Bristol","isPromoted":false},{"id":7,"name":"East Central Bristol","isPromoted":false},{"id":2,"name":"North Bristol","isPromoted":false},{"id":6,"name":"North Central Bristol","isPromoted":false},{"id":3,"name":"North East Bristol","isPromoted":false},{"id":1,"name":"North West Bristol ","isPromoted":false},{"id":9,"name":"South Bristol","isPromoted":false},{"id":8,"name":"South Central Bristol","isPromoted":false},{"id":10,"name":"South East Bristol","isPromoted":false},{"id":5,"name":"West Central Bristol","isPromoted":false}]}' , true);

		return App::make('Apiv1\Factory\UserPreferenceResponseMaker')->set($form);
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
		if( Input::get('forgotten') )
		{
			return App::make( 'ForgottenPasswordResponseMaker' )->make(Input::all());	
		}
		else
		{
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