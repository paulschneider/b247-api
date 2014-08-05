<?php namespace Apiv1\Responders;

use App;

class WhatsOnResponder {

	protected $channel = 2;

	public function get( SponsorResponder $sponsorResponder, $channelList )
	{
		// get a list of articles for this channel
		$articles = App::make('ArticleRepository')->getArticlesWithEvents(null, $this->channel);
		
		// get some adds from the sponsorResponder object
		$ads = $sponsorResponder->getUnassignedSponsors();

		// use the patternMaker to create a pattern
        $response = App::make('PatternMaker')->setPattern(1)->make( [ 'articles' => $articles, 'sponsors' => $ads ] );

        // turn this channel into the API format
        $channel = App::make('ChannelTransformer')->transform( getChannel($channelList, $this->channel) );       
        $channel['articles'] = $response->articles;

       	return [
       		'channel' => $channel, // the channel and its content 
       		'sponsors' => $response->sponsors // the sponsors allocated as part of this process
       	];
	}      
}