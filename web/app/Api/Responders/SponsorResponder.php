<?php namespace Api\Responders;

Class SponsorResponder {
	
	public function getSponsors()
	{
		$sponsors = \App::make('SponsorRepository')->getSponsors();

		return \App::make('SponsorTransformer')->transformCollection($sponsors);
	}
}