<?php namespace Apiv1\Client;

use Illuminate\Support\Facades\Facade;

Class ApiFacade extends Facade {

	public static function getFacadeAccessor()
	{
		return "ApiClient";
	}

}