<?php namespace Apiv1\Factory;

use App;
use Lang;

Class UserPreferenceResponseMaker {

	/**
	 * User object
	 * 
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user = null;

	/**
	 * list of fields that this process must have before it can be completed
	 * @var array
	 */
	protected $requiredFields = ['districts', 'channels'];

	/**
	 * instance of the user responder class
	 * 
	 * @var Apiv1\Responders\UserResponder
	 */
	private $userResponder;

	public function __construct()
	{
		$this->userResponder = App::make('UserResponder');		
	}

	public function get()
	{
		# check that we have everything need to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		if( isApiResponse($response = $this->userResponder->verify()) ) {
			return $response;
		}

		# we get the user back if everything went okay
		$this->user = $response;

		$response = [
			"channels" => $this->getChannels(),
			"districts" => $this->getDistricts()
		];

		return apiSuccessResponse( 'ok', $response );
	}

	/**
	 * get a list of channels, subChannels and categories
	 * 
	 * @return array [transformed list of channel]
	 */
	public function getChannels()
	{
		$channels = App::make('ChannelRepository')->getChannels();
		
		return App::make('Apiv1\Transformers\ChannelTransformer')->transformCollection($channels, $this->user);
	}

	/**
	 * get a list of districts and apply any user selections to them
	 * 
	 * @param  Apiv1\Repositories\Users\User $user
	 * @return array
	 */
	public function getDistricts()
	{	
		# get all the districts from the database
		$districts = App::make('Apiv1\Repositories\Districts\DistrictsRepository')->getDistricts();

		# transform them and send them back. This process sets an 'isPromoted' flag against each
		return App::make('Apiv1\Transformers\DistrictPreferenceTransformer')->transformCollection($districts->toArray(), $this->user);
	}

	public function set($data)
	{	
		# check that we have everything need to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		if( isApiResponse($response = $this->userResponder->verify($this->requiredFields, $data)) ) {
			return $response;
		}

		# we get the user back if everything went okay
		$this->user = $response;	

		# sort the provided data into the channels and categories that we want to record as being deactivated
		$response = App::make( 'UserPreferenceOrganiser' )->organise($this->user, $data);

		# update the database with these new preferences
		App::make( 'UserRepository' )->setContentPreferences($this->user, $response);	

		$promotedDistricts = App::make('Apiv1\Tools\UserDistrictOrganiser')->organise($data);

		# associate the incoming districts with the authenticated user account
		if( ! $user = App::make('Apiv1\Repositories\Users\UserRepository')->setUserDistrictPreferences($this->user, $promotedDistricts) ) {
			return apiErrorResponse( 'notAcceptable', ['errorReason' => Lang::get('api.invalidDistrictPreferenceRequest')] );
		}

		# ... and retrieve the updated user account, including these preference updates so the apps have 
		# most up to date account info
		$user =  $this->userResponder->getUserProfile($user->access_key);

		# otherwise it all went well and we can say as much to the caller
		return apiSuccessResponse( 'ok', [ 'furtherInfo' => Lang::get('api.userPreferencesUpdated') ] );
	}
}