<?php namespace Apiv1\Mail\Notifications;

interface NewEnquiryNotification {

	/**
	 * Provide a new enquiry notification
	 * 
	 * @return mixed
	 */
	public function notify($data);

}