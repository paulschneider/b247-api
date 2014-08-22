<?php namespace Apiv1\Validators;

use Lang;

Class UserProfileValidator extends ApiValidator {

	public $rules = [
		'firstName' => 'required|max:75',
		'lastName' => 'required|max:75',
		'postCode' => 'required|max:15|Postcode',
		'ageGroup' => 'required|integer',
		'facebook' => 'max:75',
		'twitter' => 'max:75'
	];

	public $messages;

	public function __construct()
	{
		$this->messages	= [
			'agegroup.required' => Lang::get('api_validation.ageGroupRequired'),
			'agegroup.integer' => Lang::get('api_validation.ageGroupInteger'),
			'postcode.validation' => Lang::get('api_validation.postcode')
		];

		$this->setRules($this->rules);
		$this->setMessages($this->messages);
	}

	public function run($form)
	{
		return $this->validate($form, $this->rules);
	}
}