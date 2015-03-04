<?php namespace Apiv1\Responders;

use App;
use Config;

class WhatsOnResponder {

	/**
	 * Whats on channel ID
	 * @var int $channel
	 */
	protected $channel;

	public function __construct()
	{
		$this->channel = Config::get('global.whatsOnChannelId');
	}

	/**
	 * return a formatted and populated whats on channel array
	 * 
	 * @param  SponsorResponder $sponsorResponder
	 * @param  array $channelList
	 * @param  User $user
	 * @return mixed
	 */
	public function get(SponsorResponder $sponsorResponder, $channelList, $user)
	{
		$limit = Config::get('constants.events');

		// get a list of articles for this channel
		$articles = App::make('ArticleRepository')->getArticles('listing', $limit, $this->channel, false, false, $user);

		// turn the articles into something nice
		$transformedArticles = App::make('ArticleTransformer')->transformCollection($articles);

		// get some adds from the sponsorResponder object
		$ads = $sponsorResponder->setSponsorType(Config::get('global.sponsorMPU'))->getUnassignedSponsors();

		// use the patternMaker to create a pattern
        $response = App::make('PatternMaker')->setPattern(2)->make( [ 'articles' => $transformedArticles, 'sponsors' => $ads ] );

        // turn this channel into the API format
        $channel = App::make('ChannelTransformer')->transform( getChannel($channelList, $this->channel), $user );  

        // assign the articles to a position in the channel array     
        $channel['articles'] = $response->articles;

       	return [
       		'channel' => $channel, // the channel and its content 
       		'sponsors' => $response->sponsors // the sponsors allocated as part of this process
       	];
	}      
}