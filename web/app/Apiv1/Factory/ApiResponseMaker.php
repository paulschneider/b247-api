<?php namespace Apiv1\Factory;

Class ApiResponseMaker {

	protected $channelSponsors = [];
	protected $allocatedSponsors;

	public function getSponsors()
	{
		$sponsorResponder = \App::make('SponsorResponder');
		$this->channelSponsors = $sponsorResponder->getSponsors();

		$this->setAllocatedSponsors( $this->channelSponsors );
		
		return $this->channelSponsors;			
	}

	public function getRandomSponsors($limit)
	{
		$sponsorRepository = \App::make('SponsorRepository');

		return $sponsorRepository->getRandomSponsors()->toArray();
	}

	public function setAllocatedSponsors($sponsors = [])
	{
		if( count($sponsors) > 0 )
		{
			foreach($sponsors AS $sponsor)
			{
				$this->allocatedSponsors[] = $sponsor['id'];
			}	
		}
	}

	public function getAllocatedSponsors()
	{
		return $this->allocatedSponsors;
	}
}