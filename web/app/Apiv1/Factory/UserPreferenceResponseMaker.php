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
	protected $requiredFields = ['districts', 'channels', 'broadcasts'];

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

	/**
	 * retrieve preferences for an authenticated user
	 * 
	 * @return apiResponse
	 */
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
			"districts" => $this->getDistricts(),
			"broadcasts" => $this->getBroadcasts()
		];
return $response;
		return apiSuccessResponse( 'ok', $response );
	}

	/**
	 * get a list of communication broadcast preferences
	 * 
	 * @return array [transformed list of preferences]
	 */
	public function getBroadCasts()
	{
		$broadcasts = App::make('Apiv1\Repositories\Broadcasts\BroadcastRepository')->getBroadcasts();

		return App::make('Apiv1\Transformers\BroadcastTransformer')->transformCollection($broadcasts, $this->user);
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

	/**
	 * when the preferences are POST'ed to the API we need to sort them and save them to the DB
	 * 
	 * @param POST $data
	 */
	public function set($data)
	{	
		$repo = App::make( 'UserRepository' );

		# check that we have everything need to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		if( isApiResponse($response = $this->userResponder->verify($this->requiredFields, $data)) ) {
			return $response;
		}

		# we get the user back if everything went okay
		$this->user = $response;	

		/*
	    |--------------------------------------------------------------------------
	    | Content preferences
	    |--------------------------------------------------------------------------
	    */

		# sort the provided data into the channels and categories that we want to record as being deactivated
		$response = App::make( 'UserPreferenceOrganiser' )->organise($this->user, $data);

		# update the database with these new preferences
		$repo->setContentPreferences($this->user, $response);	

		/*
	    |--------------------------------------------------------------------------
	    | District preferences
	    |--------------------------------------------------------------------------
	    */
		$promotedDistricts = App::make('Apiv1\Tools\UserDistrictOrganiser')->organise($data);

		# associate the incoming districts with the authenticated user account
		if( ! $user = $repo->setUserDistrictPreferences($this->user, $promotedDistricts) ) 
		{
			return apiErrorResponse( 'notAcceptable', ['errorReason' => Lang::get('api.invalidDistrictPreferenceRequest')] );
		}

		/*
	    |--------------------------------------------------------------------------
	    | Communication preferences
	    |--------------------------------------------------------------------------
	    */
	   
	    # work out which of the received preferences has been opted in to (i.e activated) or out of (i.e deactivated)
	   	$opts = App::make('Apiv1\Tools\UserBroadCastOrganiser')->organise($data, $this->user);

	   	# update the database with these new preferences
		$repo->setBroadcastPreferences($this->user, $opts->optIns);	

		# update the third-party mail client (i.e MailChimp (at this time)) with the state of the new prefs
		App::make('Apiv1\Responders\BroadcastResponder')->updateClient($this->user, $opts);

		# ... and retrieve the updated user account, including these preference updates so the apps have 
		# most up to date account info
		$user =  $this->userResponder->getUserProfile($user->access_key);

		# otherwise it all went well and we can say as much to the caller
		return apiSuccessResponse( 'ok', [ 'furtherInfo' => Lang::get('api.userPreferencesUpdated') ] );
	}
}