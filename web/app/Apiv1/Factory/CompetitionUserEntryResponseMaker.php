<?php namespace Apiv1\Factory;

use Lang;
use App;

Class CompetitionUserEntryResponseMaker {

	/**
	 * Fields that this process must receive to be completed
	 * @var array
	 */
	protected $requiredFields = ['competitionId', 'answerId'];

	/**
	 * The class repository to use
	 * 
	 * @var mixed
	 */
	protected $repo;

	/**
	 * class constructor
	 * 
	 */
	public function __construct()
	{
		$this->repo = App::make('Apiv1\Repositories\Promotions\CompetitionRepository');
	}

	/**
	 * Enter a user into a specified competition
	 * 
	 * @param  array $form [entry details]
	 * @return array $response
	 * 
	 */
	public function enterUser($form)
	{	
		# check that we have everything need to proceed including required params and auth creds. If all 
		# successful then the response is a user object
		if( isApiResponse($response = App::make('UserResponder')->verify($this->requiredFields, $form)) ) {
			return $response;
		}

		# we get the user back if everything went okay
		$user = $response;		
		
		# validate the supplied competition to ensure its still running and open to new entrants
		if( isApiResponse($response = $this->validateCompetition($form['competitionId'], $user)) ) {
			return $response;
		}

		# so we know what we got back from the validation call if we got this far
		$competition = $response;	

		# register the answer supplied by the user in the database
		$this->repo->recordEntrant($user, $competition, $form['answerId']);

		# if we got to here then everything went okay and the user was entered into the competition
		return apiSuccessResponse( 'accepted', ['public' => getMessage('public.userSuccessfullyEnterIntoCompetition'), 'debug' => getMessage('api.userSuccessfullyEnterIntoCompetition')] );
	}

	/**
	 * Ensure the competition is available, active and open to new entrants
	 * 
	 * @param int $competitionId [unique identifier for the competition]
	 * @param User $user
	 * @return mixed [API response on failure, true on validated]
	 */
	public function validateCompetition($competitionId, $user)
	{
		# grab the competition from the database
		$competition = $this->repo->get($competitionId);

		# no competition was found with the supplied ID
		if($competition->isEmpty()) {
			return apiErrorResponse( 'notFound', ['public' => getMessage('public.competitionNotFound'), 'debug' => getMessage('api.competitionNotFound')] );
		}

		# grab the competition from the array
		$competition = $competition->first();

		# check to see if its currently active. We do this here rather than the DB so we can report back to the caller
		if(! $competition->is_active) {
			return apiErrorResponse( 'locked', ['public' => getMessage('public.competitionIsInactive'), 'debug' => getMessage('api.competitionIsInactive')] );
		}

		# grab the validity data
		$validFrom = strtotime($competition->valid_from);
		$validTo = strtotime($competition->valid_to);

		# the time right NOW!
		$today = time();

		# make sure the promotion has started but not ended
		if($validFrom > $today || $validTo < $today)
        {
            return apiErrorResponse( 'forbidden', ['public' => getMessage('public.competitionOutOfRange'), 'debug' => getMessage('api.competitionOutOfRange')] );
        }

        # finally check the entrant hasn't entered this competition before
        if( $entered = $this->repo->checkEntrant($user, $competition) ) {
        	return apiErrorResponse( 'tooManyRequests', ['public' => getMessage('public.competitionAlreadyEntered'), 'debug' => getMessage('api.competitionAlreadyEntered')] );	
        }

		# send it back, its valid
        return $competition;
	}
}