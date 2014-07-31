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

}