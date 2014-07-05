<?php namespace Api\Factory;

Interface ApiResponseMakerInterface {
	
	public function getSponsors();
	public function getRandomSponsors($sponsors);
	
}