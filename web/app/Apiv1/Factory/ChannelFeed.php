<?php namespace Apiv1\Factory;

use Config;
use App;
use Apiv1\Responders\SponsorResponder;

Class ChannelFeed {

    protected $channels;
    protected $subChannels;
    protected $channelTransformer;
    protected $articleRepository;
    protected $inactiveUserChannels;
    protected $isASubChannel;

    public function __construct()
    {
        $this->channelTransformer = App::make('ChannelTransformer');
        $this->articleTransformer = App::make('ArticleTransformer');
        $this->sponsorResponder = App::make('SponsorResponder');
        $this->articleRepository = App::make('ArticleRepository');
        $this->patternMaker = App::make('PatternMaker');
    }

    public function initialise( $content = [], $inactiveUserChannels = [], $isASubChannel = false )
    {
        $this->channels = App::make('ChannelRepository')->getAllChannels();
        $this->content = $content;
        $this->inactiveUserChannels = $inactiveUserChannels;
        $this->isASubChannel = $isASubChannel;
    }

    /**
     * return an array of article/sponsors for each of the supplied sub-channels
     * @param  SponsorResponder $sponsorResponder
     * @return array
     */
    public function make(SponsorResponder $sponsorResponder)
    {
        $channelFeed = [];
        $allocatedSponsors = [];

        foreach( $this->content AS $channel )
        {
             // make sure the channel isn't in the users disabled list
            if( ! in_array($channel, $this->inactiveUserChannels) )
            {
                // get the articles for this channel
                $articles = $this->articleRepository->getArticles( null, Config::get('constants.channelFeed_limit'), $channel, $this->isASubChannel );

                // transform the articles and the sponsors into the API format 
                $articles = $this->articleTransformer->transformCollection($articles);

                $sponsors = $sponsorResponder->getUnassignedSponsors( [$channel], $this->isASubChannel );

                // create the pattern to repeat for this channel
                $response = $this->patternMaker->setPattern(1)->make( [ 'articles' => $articles, 'sponsors' => $sponsors ] );

                // grab the channel details for this channel and transform it
                $channel = $this->channelTransformer->transform( getChannel($this->channels, $channel) );

                // grab the articles from the patternMaker which are now mixed in with the ads 
                $channel['articles'] = $response->articles;

                // add the now allocated sponsors to the allocated list
                foreach($response->sponsors AS $sponsor)
                {
                    $allocatedSponsors[] = $sponsor;    
                }                

                // add the channel to channel feed
                $channelFeed[] = $channel;
            }
        }

        return [
            'channelFeed' => $channelFeed,
             'sponsors' => $allocatedSponsors
        ];

    }
}