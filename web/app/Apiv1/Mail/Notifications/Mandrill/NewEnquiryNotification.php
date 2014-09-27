<?php namespace Apiv1\Mail\Notifications\Mandrill;

use View;
use Apiv1\Mail\Notifications\NewEnquiryNotification as NewEnquiryNotificationInterface;

Class NewEnquiryNotification extends Client implements NewEnquiryNotificationInterface {

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
	var $subject = 'Bristol 24/7 Enquiry Confirmation';

	/**
	* what to tag the email as
	* @var $subject
	*/
	var $tags = ['contact-enquiry'];

	/**
	* what type of email are we sending
	* @var $subject
	*/
	var $type = 'message';

	/**
	 * who to blind courtesy copy the email to
	 * 
	 * @var string
	 */
	var $bcc;

	public function notify($data)
	{
		$this->setTo($data);
		$this->setHTML($data);

		Client::send($this);
	}

	private function setHTML($data)
	{
		$this->html = View::make("Email.EnquiryNotification", $data)->render();
	}

	private function setTo($data)
	{
		$this->toEmail = $data['email'];
		$this->toName = $data['name'];

		# if a BCC address has been configured then use that for this email request
		if(isset($_ENV['ENQUIRY_EMAIL_BCC'])) {
			$this->bcc = $_ENV['ENQUIRY_EMAIL_BCC'];	
		}
	}
}