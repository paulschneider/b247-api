<?php namespace Apiv1\Factory;

use Config;
use App;
use Apiv1\Responders\SponsorResponder;

Class ChannelFeed {

    protected $channels;
    protected $subChannels;
    protected $channelTransformer;
    protected $articleRepository;
    protected $inactiveUserChannels = [];
    protected $isASubChannel;
    protected $user = null;

    public function __construct()
    {
        $this->channelTransformer = App::make('ChannelTransformer');
        $this->articleTransformer = App::make('ArticleTransformer');
        $this->sponsorResponder = App::make('SponsorResponder');
        $this->articleRepository = App::make('ArticleRepository');
        $this->patternMaker = App::make('PatternMaker');
    }

    public function initialise( $content = [], $user = null, $isASubChannel = false )
    {
        $this->channels = App::make('ChannelRepository')->getAllChannels();
        $this->content = $content;        
        $this->isASubChannel = $isASubChannel;

        # if we have an authenticated user then see if they have any channels they don't want to see
        if( !is_null($user) ) {
            $this->user = $user;
            $this->inactiveUserChannels = $this->user->inactive_channels;
        }
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
            # make sure the channel isn't in the users disabled list
            if( ! in_array($channel, $this->inactiveUserChannels) )
            {
                # get the articles for this channel
                $articles = $this->articleRepository->getArticles( null, Config::get('constants.channelFeed_limit'), $channel, $this->isASubChannel );

                # if we have a user we need to filter all articles and remove any they have opted out of
                $articles = App::make('Apiv1\Tools\ContentFilter')->setUser($this->user)->filterArticlesByUserCategory($articles);

                # transform the articles and the sponsors into the API format 
                $articles = $this->articleTransformer->transformCollection($articles);

                # grab some sponsors we haven't yet used
                $sponsors = $sponsorResponder->setSponsorType(Config::get('global.sponsorMPU'))->getUnassignedSponsors( [$channel], $this->isASubChannel );

                # create the pattern to repeat for this channel
                $response = $this->patternMaker->setPattern(2)->make( [ 'articles' => $articles, 'sponsors' => $sponsors ], "home" );

                # grab the channel details for this channel and transform it. We pass in a user so we can see what they have enabled (or disabled)
                $channel = $this->channelTransformer->transform( getChannel($this->channels, $channel), $this->user );

                # grab the articles from the patternMaker which are now mixed in with the ads 
                $channel['articles'] = $response->articles;

                # add the now allocated sponsors to the allocated list
                foreach($response->sponsors AS $sponsor)
                {
                    $allocatedSponsors[] = $sponsor;    
                }                
  
                # add the channel to channel feed
                if( ! is_null($channel['id'])) {
                    $channelFeed[] = $channel;
                }                
            }
        }

        return [
            'channelFeed' => $channelFeed,
             'sponsors' => $allocatedSponsors
        ];
    }
}