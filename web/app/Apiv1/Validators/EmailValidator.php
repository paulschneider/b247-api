<?php namespace Apiv1\Validators;

Class EmailValidator extends ApiValidator {

	public $rules = [
		'email' => 'required|email'
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