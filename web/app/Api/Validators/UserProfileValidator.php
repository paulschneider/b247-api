<?php namespace Api\Validators;

use Lang;

Class UserProfileValidator extends ApiValidator {

	public $rules = [
		'firstname' => 'required|max:75',
		'lastname' => 'required|max:75',
		'nickname' => 'required|unique:user_profile|max:45',
		'postcode' => 'required|max:15',
		'ageGroup' => 'required|integer',
	];

	public $messages;

	public function __construct()
	{
		$this->messages	= [
			'agegroup.required' => Lang::get('api_validation.ageGroupRequired'),
			'agegroup.integer' => Lang::get('api_validation.ageGroupInteger')
		];

		$this->setRules($this->rules);
		$this->setMessages($this->messages);
	}

	public function run($form)
	{
		return $this->validate($form, $this->rules);
	}
}