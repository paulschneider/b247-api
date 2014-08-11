<?php namespace Apiv1\Mail\Notifications;

interface PromotionRedemptionEmail {

	/**
	 * Send out a notification email containing a promotional code
	 * @return mixed
	 */
	public function notify($data);
}