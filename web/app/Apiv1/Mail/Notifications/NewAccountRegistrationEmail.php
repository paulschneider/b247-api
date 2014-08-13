<?php namespace Apiv1\Mail\Notifications;

interface NewAccountRegistrationEmail {

	/**
	 * Provide an account opening confirmation email to a new user
	 * @return mixed
	 */
	public function notify($data);

}