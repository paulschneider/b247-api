<?php

class HomeController extends \BaseController
{
	public function getIndex()
	{
		$method = Request::method();

		if( Request::header('accessKey') )
		{
			require(storage_path() . '/test-data/auth.php');
		}
		else
		{
			require(storage_path() . '/test-data/no-auth.php');
		}

		$response = Response::make($data, 200);

		$response->header('Content-Type', 'application/json');

		return $response;
	}
}
