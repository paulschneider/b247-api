<?php namespace Api\Factory;

use App;
use Lang;

Class UserProfileMaker {

	private $validator;
	private $userResponder;
	private $userRepository;
	private $user;
	private $requiredFields = [ 'firstname', 'lastname', 'nickname', 'postcode', 'ageGroup' ];

	public function __construct()
	{
		$this->userResponder = App::make( 'UserResponder' );
		$this->userRepository = App::make( 'UserRepository' );
	}	

	public function make(array $form = array(), $accessKey)
	{
		// check to make sure we have all the fields required to complete the process
		if( isApiResponse( $result = $this->userResponder->parameterCheck($this->requiredFields, $form) ) )
		{
			// not all of the required fields were supplied
			return $result;
		}

		// check to see if the provided fields meet the validators requirements
		if( isApiResponse( $result = $this->userResponder->validate(App::make( 'UserProfileValidator' ), $form) ) )
		{
			// the supplied data did not meet the validation requirements
			return $result;
		}

		if( isApiResponse( $result = $this->userResponder->getUserProfile($accessKey) ) )
		{
			// we didn't find a user profile with the provided accessKey
			return $result;
		}

		$this->user = $result;

		if( isApiResponse( $result = $this->store($form)) )
		{
			// we had trouble storing the profile in the DB - bad!
			return $result;
		}

		return $this->userRepository->getProfile($accessKey);
	}

	public function store($form)
	{	
		// attempt to translate the user provided postcode to lat and lon
		$address = App::make('GoogleMapsMaker')->translatePostcode($this->user->postcode);

		if(isset($address->lat) && $address->lon)
		{
			$this->user->lat = $address->lat;
			$this->user->lon = $address->lon;	
		}		

		if( ! $result = $this->userRepository->saveProfile($this->user, $form) )
		{
			return apiErrorResponse(  'serverError', [ 'errorReason' => Lang::get('api.recordCouldNotBeSaved') ] );
		}

		return true;
	}
}