<?php namespace Apiv1\Factory;

Interface ApiResponseMakerInterface {
	
	public function getSponsors();
	public function getRandomSponsors($sponsors);
	
}