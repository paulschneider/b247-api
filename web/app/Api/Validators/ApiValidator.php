<?php namespace Api\Validators;

use Validator;

Class ApiValidator {

	public $validator;
	protected $rules;
	protected $messages = [];

	public function setRules($rules)
	{
		$this->rules = $rules;
	}

	public function setMessages($messages)
	{
		$this->messages = $messages;
	}

	public function validate($input)
	{
		$this->validator = Validator::make($input, $this->rules, $this->messages);

		if ($this->validator->fails())
	    {
	        return false;
	    }

	    return true;
	}

	public function errors()
	{
		$messages = $this->validator->messages()->toArray();

		$errors = [];

		foreach($messages AS $field => $message)
		{
			$errors[] = [
				'field' => $field,
				'message' => $message[0]
			];
		}

		return ['errors' => $errors ];
	}	
}