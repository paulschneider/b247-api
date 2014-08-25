<?php namespace Apiv1\Validators;

Class EnquiryValidator extends ApiValidator {

	public $rules = [
		'name' => 'required|max:75',
		'tel' => 'max:20',
		'email' => 'required|email:max:75',
		'message' => 'required|max:500',
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