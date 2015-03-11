<?php namespace Apiv1\Factory;

use App;
use Config;

Class HomeResponseMaker {

	protected $channelFeed;
	protected $homeChannels;
	protected $channels;
	protected $channelRepository;
	protected $sponsorResponder;

	/**
	 * User object
	 * @var Apiv1\Repositories\Users\User
	 */
	protected $user = null;

	public function __construct()
	{		
		$this->channelRepository = App::make( 'ChannelRepository' );
		$this->sponsorResponder = App::make('SponsorResponder');

		$this->homeChannels = $this->channelRepository->getTopChannelIds(); // channels to show on the homepage

		# see if we have an user accessKey present. If so we might want to show a different view of the homepage
        if( ! isApiResponse($user = App::make('UserResponder')->verify()) ) {
        	$this->user = $user;	
        }        
	}

	/**
	 * get the full channel / sub-channel / category structure
	 * 
	 * @return array [channel structure]
	 */
	public function getChannels()
	{
		$this->channels = $this->channelRepository->getChannels();

		return App::make( 'ChannelTransformer' )->transformCollection($this->channels, $this->user);
	}

	/**
	 * get featured items for the homepage
	 * 
	 * @return array [featured articles]
	 */
	public function getFeatured()
	{
		return App::make('HomeFeaturedResponder')->get($this->user);
	}

	/**
	 * return a list of articles that have been picked
	 * @return array
	 */
	public function getPicked()
	{
		$response = App::make('HomePickedResponder')->get($this->sponsorResponder);
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		return $response['articles'];
	}	

	/**
	 * Get a channel feed object containing formatted articles organised by channel
	 * 
	 * @return array
	 */
	public function getChannelFeed()
	{	
		# we handle the what's on part of the channel feed differently to everything else so
		# see if its in the channel list and remove it if so
		if(in_array(Config::get('global.whatsOnChannelId'), $this->homeChannels))
		{
			$whatsOnPosition = array_search(Config::get('global.whatsOnChannelId'), $this->homeChannels);
			unset($this->homeChannels[$whatsOnPosition]);
		}

        # create and initialise a channel feed
        $channelFeed = App::make('ChannelFeed');	
        $channelFeed->initialise($this->homeChannels, $this->user);

        # construct the channel feed
       	$response = $channelFeed->make($this->sponsorResponder);

       	# grab any sponsors that were used when creating the channel feed
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		# add the whats on content to the beginning of the channelFeed
		$whatsOn = $this->getWhatsOn();

		# whats on is handled slightly differently. Check the user hasn't disabled it then add it to
		# the response array
		if( is_null($this->user) || ! in_array($whatsOn['id'], $this->user->inactive_channels) ) 
		{
			#if there isn't an item at the whats on array position then just add whats on into the list
			if( ! array_key_exists($whatsOnPosition, $response['channelFeed']))
			{
				$response['channelFeed'][$whatsOnPosition] = $whatsOn;	
			}
			# otherwise we need to force it into the middle of the feed
			else
			{
				# grab the first bit of the array up to the point where 'whats on' was originally positioned
				$arr1 = array_slice($response['channelFeed'], 0, $whatsOnPosition);

				# grab everything else in the array
				$arr2 = array_slice($response['channelFeed'], $whatsOnPosition);
				
				# push whats on into the second half of the array at the first position
				array_unshift($arr1, $whatsOn);

				# go through all items in the second half of the array and push them onto the first half
				foreach($arr2 AS $item)
				{
					array_push($arr1, $item);
				}			

				# set the newly ordered array to be the channel feed
				$response['channelFeed'] = $arr1;
			}			
		}

		# ... and send it back.
		return $response['channelFeed'];
	}

	/**
	 * get the What's On section of the homepage
	 * 
	 * @return array [the whats on channel feed item]
	 */
	public function getWhatsOn()
	{
		$response = App::make('WhatsOnResponder')->get( $this->sponsorResponder, $this->channels, $this->user );

		# we want to order the list of returned articles by the created date and time
		# this is only done on the home page so we'll do that here
		 
		$articles = [];

		foreach($response['channel']['articles'] AS $article)
		{
			if( ! $article['isAdvert'] )
			{
				# convert the date time
				$dateTime = strtotime($article['created']);

				# check to make we don't over-write an article that was created at exactly the same time (unlikely)
				if( array_key_exists($dateTime, $articles) )
				{
					# we'll just try to increment the time by a fraction of a second to slip it into the array
					# we'll try this 10 times as its very unlikely this scenario will happen
					for($i=1; $i < 10; $i++)
					{
						# as soon as we find a place for the article in the array we break out of the loop
						if( ! array_key_exists($dateTime+$i, $articles) )
						{
							break;
						}					
					}
				}	

				# ... and finally add the article into the array at the desired position
				$articles[$dateTime] = $article;
			}		
		}

		# sort the articles array by the array key which is the dateTime value, descending order
		krsort($articles);

		# over-write the original articles array with the newly sorted one
		$response['channel']['articles'] = array_values($articles);

		# set the sponsors allocated as part of this process so we don't use them again
		$this->sponsorResponder->setAllocatedSponsors($response['sponsors']);

		# ... and provide the response back to the source call
		return $response['channel'];
	}

	/**
	 * From the various methods in this class create a response object for the homepage
	 * 
	 * @return mixed 
	 */
	public function make()
	{ 
		# try and find the channels. If not, return the response returned by the call
		if( isApiResponse( $result = $this->getChannels() ) ) {
			return $result;
		}

		# get 3 related adverts and set them as allocated
		$adverts = $this->sponsorResponder->setSponsorType()->getChannelSponsors(3, $this->homeChannels); 
		$this->sponsorResponder->setAllocatedSponsors($adverts);

		# the main response array
		$response = [
			'channels' => $this->getChannels(),
            'adverts' => $adverts,
            'features' => $this->getFeatured(),
            'picks' => $this->getPicked(),
            'channelFeed' => $this->getChannelFeed(),
        ];        

		return apiSuccessResponse( 'ok', $response ); 
	}
}