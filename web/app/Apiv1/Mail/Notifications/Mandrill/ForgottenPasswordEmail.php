<?php namespace Apiv1\Mail\Notifications\Mandrill;

use View;
use Apiv1\Mail\Notifications\ForgottenPasswordEmail as ForgottenPasswordEmailInterface;

Class ForgottenPasswordEmail extends Client implements ForgottenPasswordEmailInterface {

	/**
	* email address to send from
	* @var $fromEmail
	*/
	var $fromEmail = 'notifications@bristol247.com';

	/**
	* name displayed to the recipient as the 'from' name
	* @var $fromName
	*/
	var $fromName = 'Notifications';

	/**
	* email address to send to
	* @var $toEmail
	*/
	var $toEmail;

	/**
	* name of the recipient
	* @var $toName
	*/
	var $toName;

	/**
	* the subject line to show for the email
	* @var $subject
	*/
	var $subject = 'Account password updated';

	/**
	* what to tag the email as
	* @var $subject
	*/
	var $tags = ['password-reminder'];

	/**
	* what type of email are we sending
	* @var $subject
	*/
	var $type = 'message';

	public function notify($data)
	{
		$this->setTo($data);
		$this->setHTML($data);

		Client::send($this);
	}

	private function setHTML($data)
	{
		$this->html = View::make("Email.ForgottenAccountPassword", $data)->render();
	}

	private function setTo($data)
	{
		$this->toEmail = $data['email'];
	}
}