<?php

use Apiv1\Mail\Newsletters\NewsletterList;

Class MailController extends BaseController {

	public function __construct(NewsletterList $newsletterList)
	{
		$this->newsletter = $newsletterList;
	}

	public function verifyUserIsSubscribed()
	{
		return Response::json($this->newsletter->confirmUserSubscribed(Input::get('list'), Input::get('email')));
	}
}