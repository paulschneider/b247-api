<?php namespace Version1\Controllers;

use Request;
use Response;
use View;
use Input;

class RegisterController extends ApiController {

	/**
	*
	* @var Api\Transformers\UserTransformer
	*/
	protected $userTransformer;

	public function __construct(\Api\Transformers\UserTransformer $userTransformer)
	{
		$this->userTransformer = $userTransformer;
	}

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
		$user = \Version1\Models\User::addUser(Input::all());

		if( ! $user->save() )
		{
			return $this->respondNotValid($user->errors);
		}
		else
		{
			return $this->respondCreated('User successfully registered', $this->userTransformer->transform($user->toArray()));
		}
	}

	/**
	* Coverall for any HTTP requests that are not covered by implemented methods
	*
	* @return Response
	*/
	public function missingMethod($parameters=array())
	{
		$this->respondNotSupported('Endpoint does not support method.');
	}
}