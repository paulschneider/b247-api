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
}