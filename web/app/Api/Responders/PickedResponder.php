<?php namespace Api\Responders;

class PickedResponder {

	public function get( $channel, $caller )
	{
		$articleRepository = \App::make('ArticleRepository');
		$sponsorRepository = \App::make('SponsorRepository');
		$patternMaker = \App::make('PatternMaker');

		$articleTransformer = \App::make('ArticleTransformer');
		$sponsorTransformer = \App::make('SponsorTransformer');

        $picks = $articleRepository->getArticles( 'picks', 25, $channel['id'] );
        $ads = $sponsorRepository->getWhereNotInCollection( $caller->getAllocatedSponsors(), 30 )->toArray();

        $articles = $articleTransformer->transformCollection( $picks );
        $sponsors = $sponsorTransformer->transformCollection( $ads );

        $response = $patternMaker->make( [ 'articles' => $articles, 'sponsors' => $sponsors ] );
        $articles = $response->articles;

     	// let the calling function know which sponsors have been used up so we don't repeat them on the channel
        $caller->setAllocatedSponsors($response->sponsors);

        return $articles;
	}      
}