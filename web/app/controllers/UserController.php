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
		$form = [
			'email' => 'paul.schneider@yepyep.co.uk',
			'accessKey' => 'OGuzm6pDHsFwrXW6Zb0ICc1iR',
			'password' => 'password',
			'newPassword' => 'password1'
		];

		return $this->responseMaker->make($form);
	}

}