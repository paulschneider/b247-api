<?php namespace Apiv1\Mail;

Class Client extends MandrillClient {		

	public function request($email, $data)
	{
		$email = new $email;

		$email->set($data);

		$result = parent::send($email);
	}
}