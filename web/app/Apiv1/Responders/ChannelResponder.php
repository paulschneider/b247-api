<?php namespace Apiv1\Responders;

use App;
use Apiv1\Repositories\Channels\Toolbox;

Class ChannelResponder {

	public function getChannel( $identifier, $user )
	{
		$channelRepository = App::make( 'ChannelRepository' );

        # try and find the channel. If not, return an error
        if( ! $channel = $channelRepository->getChannelByIdentifier( $identifier )) {
            return apiErrorResponse( 'notFound' );
        }

		$parentChannel = $channelRepository->getChannelBySubChannel( $channel );		
		$channel = App::make( 'ChannelTransformer' )->transform( Toolbox::filterSubChannels( $parentChannel, $channel ), $user );

		return $channel;
	}

	public function getArticles($channel, $user)
	{	
        # the channel type (article, listing, directory, promotion)
		$type = getSubChannelType( $channel );

        #grab the sub-channel ID from the main channel array
		$subChannelId = getSubChannelId($channel);		

        # get some articles
		$articles = App::make('ArticleRepository')->getArticles( $type, 25, $subChannelId, true, false, $user ); 

		# if we have a user we need to filter all articles and remove any they have opted out of
        $articles = App::make('Apiv1\Tools\ContentFilter')->setUser($user)->filterArticlesByUserCategory($articles);

        # transform the response into the API required format
        return App::make('ArticleTransformer')->transformCollection($articles);
    }
}