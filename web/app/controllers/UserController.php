<?php

use Api\Factory\PasswordChangeResponseMaker;

Class UserController extends BaseController {

	public $responseMaker;

	public function __construct(PasswordChangeResponseMaker $responseMaker)
	{
		$this->responseMaker = $responseMaker;
	}

	public function changeUserPassword()
	{
		return $this->responseMaker->make(Input::all());
	}

}