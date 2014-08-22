<?php namespace Apiv1\Responders;

use App;
use Config;
use stdClass;

Class SponsorResponder {

	/**
	 * the type of sponsor
	 * 
	 * @var int
	 */
	public $sponsorType;

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
		$sponsors = App::make('SponsorRepository')->getChannelSponsors($limit, $channelList, $subChannel, [], $this->sponsorType);

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
		$sponsorRepository = App::make('SponsorRepository');
		$sponsorTransformer = App::make('SponsorTransformer');

		# grab the subChannelId from this channel (helper function)
		$subChannelId = getSubChannelId($this->channel);

		// grab some sponsors and filter them by the requested category
		# $limit = how many to return
		# $subChannelId = which sub-channel do we want to get the ads for
		# $this->category['id'] = which category of this sub-channel do we want to get ads for
		# $this->getAllocatedSponsors() = provide an array of sponsors already used on the page. Helps to provide unique sponsors as we wont get these ones back
		# $this->sponsorType = which type of sponsor do we want to get back
		$sponsors = $sponsorRepository->getCategorySponsors($limit, $subChannelId, $this->category['id'], $this->getAllocatedSponsors(), $this->sponsorType);

		# we also now want to retrieve a random full page article which will be displayed periodically within the app
		$fullPageAd = $sponsorRepository->getCategorySponsors(1, $subChannelId, $this->category['id'], $this->getAllocatedSponsors(), Config::get('global.sponsorFULLPAGE'));

		$response = new stdClass();
		$response->sponsors = null;
		$response->fullPage = null;

		# if we managed to find a fullpage advert then push it into the sponsors array
		if(isset($fullPageAd[0])) {
			$response->fullPage = $sponsorTransformer->transform($fullPageAd[0]);
		}

		# transform them in to the API format 
		$response->sponsors = $sponsorTransformer->transformCollection($sponsors);

		# send the response back
		return $response;
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

	/**
	 * set the type of sponsor we want to retrieve, such as letterbox or MPU
	 * 
	 * @param int $type [numerical identifier for the type of sponsor (advert) we want to retrieve]
	 */
	public function setSponsorType($type = null)
	{
		if( ! is_null($type)) {
			$this->sponsorType = $type;
		}
		else {
			$this->sponsorType = Config::get('global.sponsorLETTERBOX');
		}

		return $this;
	}
}