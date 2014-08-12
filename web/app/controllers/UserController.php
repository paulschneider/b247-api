<?php

Class UserController extends BaseController {	

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

	public function profile()
	{
		return App::make( 'UserProfileResponseMaker' )->make(Input::all());
	}

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
}