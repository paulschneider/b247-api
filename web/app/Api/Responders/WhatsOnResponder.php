<?php namespace Api\Responders;

class WhatsOnResponder {

	protected $channel = 50;

	public function get( $sponsors, $caller, $allChannelsList)
	{
		$articleRepository = \App::make('ArticleRepository');
		$patternMaker = \App::make('PatternMaker');
		$articleTransformer = \App::make('ArticleTransformer');
		$sponsorTransformer = \App::make('SponsorTransformer');
		$channelTransformer = \App::make('ChannelTransformer');

		$articles = $articleRepository->getArticlesWithEvents(null);

		$sponsors = $sponsorTransformer->transformCollection( $sponsors );
        $articles = $articleTransformer->transformCollection( $articles );

        $response = $patternMaker->make( [ 'articles' => $articles, 'sponsors' => $sponsors ] );
        $articles = $response->articles;

        // let the calling function know which sponsors have been used up so we don't repeat them on the channel
        $caller->setAllocatedSponsors($response->sponsors);

        $channel = $channelTransformer->transform( getChannel($allChannelsList, $this->channel) );
       	
        $channel['articles'] = $articles;

       	return $channel;
	}      
}