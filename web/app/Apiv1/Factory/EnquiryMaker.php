<?php namespace Apiv1\Factory;

use App;
use Apiv1\Validators\EnquiryValidator;
use Apiv1\Mail\Notifications\NewEnquiryNotification;

Class EnquiryMaker {

	/**
	 * what fields does this process require
	 * 
	 * @var array
	 */
	private $requiredFields = ['name', 'email', 'message'];

	/**
	 * class constructor
	 * 
	 * @param EnquiryValidator $validator
	 */
	public function __construct(EnquiryValidator $validator, NewEnquiryNotification $emailer)
	{
		$this->validator = $validator;
		$this->notifier = $emailer;
	}

	/**
	 * process a new enquiry submitted via the website or other client device
	 * 
	 * @param  array $form
	 * @return ApiResponse
	 */
	public function enquire($form)
	{
		$userResponder = App::make( 'UserResponder' );

		# check to make sure we have all the fields required to complete the process
		if( isApiResponse( $result = $userResponder->parameterCheck($this->requiredFields, $form) ) ) {
			// not all of the required fields were supplied
			return $result;
		}

		# check to see if the provided fields meet the validators requirements
		if( isApiResponse($result = $userResponder->validate($this->validator, $form)) ) {
			# the supplied data did not meet the validation requirements
			return $result;
		}

		# save the enquiry to the database
		App::make('Apiv1\Repositories\Enquiries\Enquiry')->store($form);

		# send out a confirmation email
		$this->notifier->notify($form);

		# send a response out of the API that everything went okay
		return ApiSuccessResponse('ok', ['public' => getMessage('public.contactEnquirySent'), 'debug' => getMessage('api.contactEnquirySent')]);	}
}