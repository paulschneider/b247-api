<?php namespace Api\Factory;

Class ApiResponseMaker {

	protected $channelSponsors;
	protected $allocatedSponsors;

	public function __construct()
	{
		$this->channelSponsors = $this->getSponsors();

		$this->setAllocatedSponsors( $this->channelSponsors );
	}

	public static function RespondWithError($message)
	{
		throw new \Api\Exceptions\InvalidResponseException($message);
	}

	public function getSponsors()
	{
		$sponsorResponder = \App::make('SponsorResponder');

		return $sponsorResponder->getSponsors();
	}

	public function getRandomSponsors($limit)
	{
		$sponsorRepository = \App::make('SponsorRepository');

		return $sponsorRepository->getRandomSponsors()->toArray();
	}

	public function setAllocatedSponsors($sponsors = [])
	{
		foreach($sponsors AS $sponsor)
		{
			$this->allocatedSponsors[] = $sponsor['id'];
		}
	}

	public function getAllocatedSponsors()
	{
		return $this->allocatedSponsors;
	}
}