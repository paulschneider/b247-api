<?php namespace Apiv1\Mail\Newsletters\Mailchimp;

use Apiv1\Mail\Newsletters\NewsletterList as NewsletterListInterface;
use Mailchimp;
use Exception;

Class NewsletterList implements NewsletterListInterface {

	/**
	 * @var $mailChimp
	 */
	protected $mailChimp;

	/**
	 * @var $lists
	 */
	protected $lists = [
		'daily-digest' => 'a5363557d4'
	];

	/**
	 * @param Mailchimp $mailChimp
	 */
	public function __construct(Mailchimp $mailChimp)
	{
		$this->mailChimp = $mailChimp;
	}

	/**
	 * subscribe a user to a mailchimp list
	 * @return [type]
	 */
	public function subscribeTo($listName, $email)
	{
		try
		{
			$this->mailChimp->lists->subscribe(
				$this->lists[$listName], // the list to add the subscriber to
				['email' => $email], // the email address of the subscriber
				null, // merge_vars
				'html', // email type
				false, // double opt in (have a secondary email sent to the user that they have to click on to confirm subscription)
				false, // update existing user
				true // update existing user (default is false)
			); 	
		}
		# Fail silently if the user is already registered
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}

	/**
	 * Unsubscribe a user from a specified list
	 * @return mixed
	 */
	public function unsubscribeFrom($listName, $email)
	{
		$this->mailChimp->lists->unsubscribe(
			$this->lists[$listName], // the list to add the subscriber to
			['email' => $email], // the email address of the subscriber
			false, // delete_member from the list
			false, // send a goodbye email
			false // send a notification email to the un-subcribe email address set in the settings of this list (in mailchimp)
		);
	}

	/**
	 * Un-subscribe a specified user from a mail list
	 * 
	 * @param  string $list
	 * @param  string $email
	 * @return null
	 */
	public function confirmUserSubscribed($listName, $email)
	{
		$data = $this->mailChimp->lists->memberInfo(
			$this->lists[$listName], // the list to check
			[[ 'email' => $email]] // an array of email address. Each email must be in its own array
		);

		# Mailchimp reported an error and that it could not find the supplied email address
		if( $data['error_count'] && $data['errors'][0]['code'] == 232 )
		{
			return false;
		}

		return true;
	}
}