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
	* if a PUT request is made
	*
	* @return Response
	*/
	public function putIndex()
	{
		return $this->respondNotAllowed();
	}

	/**
	* if a PATCH request is made
	*
	* @return Response
	*/
	public function patchIndex()
	{
		return $this->respondNotAllowed();
	}

	/**
	* if a DELETE request is made
	*
	* @return Response
	*/
	public function deleteIndex()
	{
		return $this->respondNotAllowed();
	}
}
