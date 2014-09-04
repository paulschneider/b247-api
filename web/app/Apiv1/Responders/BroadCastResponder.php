<?php namespace Apiv1\Responders;

use App;
use Apiv1\Mail\Newsletters\NewsletterList;

Class BroadCastResponder {

	/**
	 * the repository to use for this class
	 * 
	 * @var mixed
	 */
	protected $repo;

	/**
	 * Apiv1\Mail\Newsletters\NewsletterList
	 * 
	 * @var NewsletterList $newsLetter
	 */
	protected $newsLetter;

	/**
	 * the authenticated user
	 * 
	 * @var User
	 */
	protected $user;

	/**
	 * array of mailing the user has chosen to receive
	 * 
	 * @var array
	 */
	private $optIns;

	/**
	 * array of mailing the user has chosen NOT to receive
	 * 
	 * @var array
	 */
	private $optOuts;

	/**
	 * array of communication preferences
	 * 
	 * @var array
	 */
	private $broadcasts;

	/**
	 * class constructor
	 */
	public function __construct(NewsletterList $newsletterList)
	{
		# set the repository for the class to use
		$this->repo = App::make('Apiv1\Repositories\Broadcasts\BroadcastRepository');

		# which newsletter interface do we want to use
		$this->newsletter = $newsletterList;
	}

	/**
	 * entry point to the class. mainly just a DTO
	 * @param  User $user
	 * @param  stdClass $options
	 * 
	 * @return null
	 */
	public function updateClient($user, $options)
	{
		# the auth user
		$this->user = $user;

		# what the user has chosen to opt IN to
		$this->optIns = $options->optIns;

		# what the user has chosen to opt OUT of
		$this->optOuts = $options->optOuts;

		# get a list of broadcasts from the database
		$this->broadcasts = $this->repo->getBroadcasts();

		# process the opt-ins
		$this->subscribe();

		# process the opt-outs
		$this->unsubscribe();
	}

	/**
	 * process all opt ins to ensure that the user is subscribed to each mailing list provided
	 * 
	 * @return null
	 */
	private function subscribe()
	{
		# go through the list of optIns and subscribe the user to the mailing list
		foreach($this->optIns AS $optIn)
		{
			# we need to know which broadcast ID the user wants to subscribe to
			$broadCastId = $optIn['communication_id'];			

			# and the corresponding list name. This is a communication row tag from the communication table
			# this tag is whats stored in the mail client and is used to segment users into lists
			# to be emailed
			$listName = $this->broadcasts->find($broadCastId)->tag;
			
			# subscribe the user to the mail list
			$this->newsletter->subscribeTo($listName, $this->user->email);
		}
	}

	/**
	 * process all opt outs to ensure the user is UNSUBSCRIBED from each mailing list
	 * 
	 * @return null
	 */
	public function unsubscribe()
	{
		# go through the list of opt-outs and un-subscribe the user from each mailing list
		foreach($this->optOuts AS $optOut)
		{
			# we need to know which broadcast ID the user wants to un-subscribe from
			$broadCastId = $optOut['communication_id'];			

			# and the corresponding list name. This is a communication row tag from the communication table
			# this tag is whats stored in the mail client and is used to segment users into lists
			# to be emailed
			$listName = $this->broadcasts->find($broadCastId)->tag;
	
			# un-subscribe the user from the mail list
			$this->newsletter->unsubscribeFrom($listName, $this->user->email);
		}
	}
}