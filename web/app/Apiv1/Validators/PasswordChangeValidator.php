<?php namespace Apiv1\Validators;

Class PasswordChangeValidator extends ApiValidator {

	public $rules = [
		'password' => 'required|max:30',
		'newPassword' => 'required|max:30',
	];

	public function __construct()
	{
		$this->setRules($this->rules);
	}

	public function run($form)
	{
		return $this->validate($form, $this->rules);
	}

}