<?php namespace Apiv1\Mail\Newsletters;

interface NewsletterList {

	/**
	 * Subscribe a user to a specified mail list
	 * 
	 * @param  string $list
	 * @param  string $email
	 * @return null
	 */
	public function subscribeTo($list, $email);

	/**
	 * Un-subscribe a specified user from a mail list
	 * 
	 * @param  string $list
	 * @param  string $email
	 * @return null
	 */
	public function unsubscribeFrom($list, $email);

	/**
	 * Check that a user email is registered in the mailing list
	 * 
	 * @param  string $email [the email address of the registered user]
	 * @return boolean $status [whether the user is registered]
	 */
	public function confirmUserSubscribed($list, $email);

}