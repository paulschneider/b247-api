<?php namespace Api\Validators;

Class RegistrationValidator extends ApiValidator {

	public $rules = [
		'firstName' => 'required',
		'lastName' => 'required',
		'email' => 'required|email|unique:user'
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