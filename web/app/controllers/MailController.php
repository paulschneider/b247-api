<?php

use Apiv1\Mail\Newsletters\NewsletterList;

Class MailController extends BaseController {

	public function __construct(NewsletterList $newsletterList)
	{
		$this->newsletter = $newsletterList;
	}

	/**
	 * confirm that a specified email address has been registered for a particular newsletter
	 * 
	 * @return boolean
	 */
	public function verifyUserIsSubscribed()
	{
		return Response::json($this->newsletter->confirmUserSubscribed(Input::get('list'), Input::get('email')));
	}

	/**
	 * submit, store and email a new contact enquiry message received through the app/websiet
	 * 
	 * @return ApiResponse
	 */
	public function newContactEnquiry()
	{
		return App::make('Apiv1\Factory\EnquiryMaker')->enquire(Input::all());
	}
}