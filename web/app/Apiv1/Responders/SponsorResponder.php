<?php namespace Apiv1\Responders;

use App;
use Config;

Class SponsorResponder {

	/**
	 * A list of allocated sponsors
	 * @var array
	 */
	protected $allocatedSponsors = [];
	
	/**
	 * Get a list of sponsors assigned to a provided array of channel ID's
	 * @param  int  $limit
	 * @param  array  $channelList
	 * @param  boolean $subChannel
	 * @return array
	 */
	public function getChannelSponsors($limit, $channelList, $subChannel = false)
	{
		$sponsors = App::make('SponsorRepository')->getChannelSponsors($limit, $channelList, $subChannel, [], Config::get('global.sponsorLETTERBOX'));

		// transform them in to the API format 
		$transformedSponsors = App::make('SponsorTransformer')->transformCollection($sponsors);

		return $transformedSponsors;
	}

	/**
	 * get a list of sponsors assigned to this sub-channel/category combination
	 * @param  int $limit
	 * @return mixed
	 */
	public function getCategorySponsors($limit)
	{
		// grab the subChannelId from this channel (helper function)
		$subChannelId = getSubChannelId($this->channel);

		// grab some sponsors and filter them by the requested category
		# $limit = how many to return
		# $subChannelId = which sub-channel do we want to get the ads for
		# $this->category['id'] = which category of this sub-channel do we want to get ads for
		# $this->getAllocatedSponsors() = provide an array of sponsors already used on the page. Helps to provide unique sponsors as we wont get these ones back
		# Config::get('global.sponsorLETTERBOX') = which type of sponsor do we want to get back, in this case page wide letterbox ads
		$sponsors = App::make('SponsorRepository')->getCategorySponsors($limit, $subChannelId, $this->category['id'], $this->getAllocatedSponsors(), Config::get('global.sponsorLETTERBOX'));

		// transform them in to the API format 
		$transformedSponsors = App::make('SponsorTransformer')->transformCollection($sponsors);

		// send them back
		return $transformedSponsors;
	}

	/**
	 * return an array of sponsors already used on the channel
	 * @return array 
	 */
	public function getAllocatedSponsors()
	{
		return $this->allocatedSponsors;
	}

	/**
	 * Sort a list of transformed sponsors into an array of ID's so we know which has been used
	 * @param array $sponsors
	 */
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

	public function getUnassignedSponsors($channelList = [], $subChannel = false)
	{
		return $this->getChannelSponsors(
			50, // limit
			$channelList, // which channel sponsors we want 
			$subChannel, // is it a subChannel
			$this->getAllocatedSponsors()
		);
	}
}