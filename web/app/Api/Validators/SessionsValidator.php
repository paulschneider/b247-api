<?php namespace Api\Validators;

// validator for sessions (log, auth etc...)

Class SessionsValidator extends ApiValidator {

	public $rules = [
		'email' => 'required|email',
		'password' => 'required|max:30'
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