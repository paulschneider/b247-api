<?php namespace Apiv1\Mail\Notifications;

interface ForgottenPasswordEmail {

	/**
	 * Provide a new password to an existing user
	 * @return mixed
	 */
	public function notify($data);

}