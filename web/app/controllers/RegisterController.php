<?php

use Version1\Users\UserRepository;
use Api\Transformers\UserTransformer;

class RegisterController extends ApiController {

	/**
	*
	* @var Api\Transformers\UserTransformer
	*/
	protected $userTransformer;

	/**
	*
	* @var Version1\Users\UserRepository
	*/
	protected $userRepository;

	public function __construct(UserTransformer $userTransformer, UserRepository $userRepository)
	{
		$this->userTransformer = $userTransformer;
		$this->userRepository = $userRepository;
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
		$user = $this->userRepository->addUser(Input::all());

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
		return $this->respondNotAllowed();
	}
}
