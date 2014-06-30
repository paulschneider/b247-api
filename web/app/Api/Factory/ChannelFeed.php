<?php namespace Api\Factory;

use Version1\Articles\ArticleRepository;
use Api\Transformers\ChannelTransformer;
use Api\Factory\PatternMaker;

Class ChannelFeed {

    protected $channels;
    protected $subChannels;
    protected $ads;
    protected $channelTransformer;
    protected $articleRepository;
    protected $inactiveUserChannels;
    protected $theseAreSubChannels;

    public function __construct( $channels = [], $subChannels = [], $ads = [], $inactiveUserChannels = [], $theseAreSubChannels = false )
    {
        $this->channelTransformer = new ChannelTransformer();
        $this->articleRepository = new ArticleRepository();
        $this->patternMaker = new PatternMaker();

        $this->channels = $channels;
        $this->subChannels = $subChannels;
        $this->ads = $ads;
        $this->inactiveUserChannels = $inactiveUserChannels;
        $this->theseAreSubChannels = $theseAreSubChannels;
    }

    public function make()
    {
        $channelFeed = [];

        foreach( $this->subChannels AS $channel )
        {
            if( ! in_array($channel, $this->inactiveUserChannels) )
            {
                $articles = $this->articleRepository->getArticles( null, 20, $channel, $this->theseAreSubChannels );
                $response = $this->patternMaker->make( [ 'articles' => $articles, 'sponsors' => $this->ads ] );
                $articles = $response->articles;
                $ads = $response->sponsors;

                $channel = $this->channelTransformer->transform( getChannel($this->channels, $channel) );
                $channel['articles'] = $articles;

                $channelFeed[] = $channel;
            }
        }

        return $channelFeed;
    }
}