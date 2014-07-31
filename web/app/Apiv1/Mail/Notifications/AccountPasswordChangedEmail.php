<?php namespace Apiv1\Mail\Notifications;

interface AccountPasswordChangedEmail {

	/**
	 * Provide confirmation of the user password change
	 * @return mixed
	 */
	public function notify($data);

}