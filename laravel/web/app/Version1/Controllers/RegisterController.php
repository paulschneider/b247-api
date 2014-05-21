<?php

namespace Version1\Controllers;

use Request;
use Response;
use View;
use Input;

class RegisterController extends BaseController {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		return View::make('register.show');

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = new \Version1\Models\User(Input::all());

		if( ! $user->save() )
		{

			dd($user->errors);

		}
		else
		{

			exit('saved');

		}
	}
}
