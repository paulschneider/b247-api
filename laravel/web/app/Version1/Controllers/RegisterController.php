<?php namespace Version1\Controllers;

use Request;
use Response;
use View;
use Input;
use \Api\Transformers\UserTransformer;

class RegisterController extends ApiController {

	/**
	*
	* @var Api\Transformers\UserTransformer
	*/
	protected $userTransformer;

	public function __construct(UserTransformer $userTransformer)
	{
		$this->userTransformer = $userTransformer;
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function index()
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
	* return a not supported error if an edit is called
	*
	* @return ApiResponse
	*/
	public function edit()
	{
		return ApiController::respondNotAllowed();
	}
}
