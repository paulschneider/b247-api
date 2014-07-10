<?php namespace Api\Factory;

Class ChannelFeed {

    protected $channels;
    protected $subChannels;
    protected $ads;
    protected $channelTransformer;
    protected $articleRepository;
    protected $sponsorRepository;
    protected $inactiveUserChannels;
    protected $isASubChannel;
    protected $allocatedSponsors = [];

    public function __construct()
    {
        $this->channelTransformer = \App::make('ChannelTransformer');
        $this->articleTransformer = \App::make('ArticleTransformer');
        $this->sponsorTransformer = \App::make('SponsorTransformer');
        $this->articleRepository = \App::make('ArticleRepository');
        $this->sponsorRepository = \App::make('SponsorRepository');
        $this->patternMaker = \App::make('PatternMaker');
    }

    public function initialise( $channels = [], $subChannels = [], $ads = [], $inactiveUserChannels = [], $isASubChannel = false )
    {
        $this->channels = $channels;
        $this->subChannels = $subChannels;
        $this->ads = $ads;
        $this->inactiveUserChannels = $inactiveUserChannels;
        $this->isASubChannel = $isASubChannel;
    }

    public function make()
    {
        $channelFeed = [];
        $allocatedSponsors = [];

        foreach( $this->subChannels AS $channel )
        {
            // make sure the channel isn't in the users disabled list
            if( ! in_array($channel, $this->inactiveUserChannels) )
            {
                // get the articles for this channel
                $articles = $this->articleRepository->getArticles( null, 20, $channel, $this->isASubChannel );

                // transform the articles and the sponsors into the API version 
                $articles = $this->articleTransformer->transformCollection($articles);
                $sponsors = $this->sponsorTransformer->transformCollection($this->ads);

                // create the patter to repeat for this channel
                $response = $this->patternMaker->make( [ 'articles' => $articles, 'sponsors' => $sponsors ] );

                // grab the channel details for this channel and transform it
                $channel = $this->channelTransformer->transform( getChannel($this->channels, $channel) );

                // grab the articles from the patternMaker which are now mixed in with the ads 
                $channel['articles'] = $response->articles;

                // add the channel to channel feed
                $channelFeed[] = $channel;

                // grab the sponsors from the patternMaker response. We don't want to use these again
                $this->setAllocatedSponsors( $response->sponsors );

                // grab a load of new sponsors we haven't used before
                $this->ads = $this->sponsorRepository->getWhereNotInCollection( $this->getAllocatedSponsors(), 100 )->toArray();
            }
        }

        return $channelFeed;
    }

    public function setAllocatedSponsors($sponsors = [])
    {
        foreach($sponsors AS $sponsor)
        {
            $this->allocatedSponsors[] = $sponsor['id'];
        }
    }

    public function getAllocatedSponsors()
    {
        return $this->allocatedSponsors;
    }
}