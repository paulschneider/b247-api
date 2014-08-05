<?php namespace Apiv1\Responders;

use App;

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
		$result = App::make('SponsorRepository')->getChannelSponsors($limit, $channelList, $subChannel);

		// with the way this call has been made the sponsor object needs to be extracted
        $sponsors = [];
        foreach($result AS $r)
        {
            $sponsors[] = $r['sponsor'][0];
        }

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
		$result = App::make('SponsorRepository')->getCategorySponsors($limit, $subChannelId, $this->category['id'], $this->getAllocatedSponsors());

		// with the way this call has been made the sponsor object needs to be extracted
        $sponsors = [];
        foreach($result AS $r)
        {
            $sponsors[] = $r['sponsor'][0];
        }

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