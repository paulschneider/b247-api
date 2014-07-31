<?php namespace Apiv1\Mail;

use View;

Class RegistrationEmail {

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
	var $subject = 'New Account';

	/**
	* what to tag the email as
	* @var $subject
	*/
	var $tags = ['subscriber-registration'];

	/**
	* what type of email are we sending
	* @var $subject
	*/
	var $type = 'message';

	public function set($data)
	{
		$this->setTo($data);
		$this->setHTML($data);

		return $this;
	}

	private function setHTML($data)
	{
		$this->html = View::make("Email.SubscriberRegistration", $data)->render();
	}

	private function setTo($data)
	{
		$this->toEmail = $data['user']['email'];
		$this->toName = $data['user']['firstName'] .' '. $data['user']['lastName'];
	}
}