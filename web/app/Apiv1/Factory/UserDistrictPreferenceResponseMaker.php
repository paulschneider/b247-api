<?php namespace Apiv1\Factory;

use App;
use Lang;

Class UserDistrictPreferenceResponseMaker {

	/**
	 * User object
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user = null;

	/**
	 * list of fields that this process must have before it can be completed
	 * @var array
	 */
	protected $requiredFields = ['districts'];

	/**
	 * the repository to use for this process
	 * @var Apiv1\Repositories\Users\UserRepository
	 */
	protected $repo;

	/**
	 * class constructor
	 */
	public function __construct()
	{
		$this->repo = App::make('Apiv1\Repositories\Users\UserRepository');
	}

	public function updateUserDistricts($form)
	{
		# check that we have everything need to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		if( isApiResponse($response = App::make('UserResponder')->verify($this->requiredFields, $form)) ) {
			return $response;
		}

		# we get the user back if everything went okay
		$user = $response;

		# associate the incoming districts with the authenticated user account
		if( ! $user = $this->repo->setUserDistrictPreferences($user, $form['districts']) )
		{
			return apiErrorResponse( 'notAcceptable', ['errorReason' => Lang::get('api.invalidDistrictPreferenceRequest')] );
		}

		# otherwise it all went well and we can say as much to the caller
		return apiSuccessResponse( 'ok', [ 'user' => App::make('UserTransformer')->transform($user->toArray()) ] );
	}
}