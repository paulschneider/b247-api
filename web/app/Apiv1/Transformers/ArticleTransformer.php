<?php namespace Apiv1\Transformers;

use App;

Class ArticleTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transformCollection( $articles, $options = [ 'showBody' => false ] )
    {
        $response = [];

        foreach($articles AS $article)
        {
            $response[] = $this->transform($article, $options);
        }
        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [ 'showBody' => false ] )
    {
        if( isset($article['location'][0]) )
        {
            $articleLocation = $article['location'][0];            

            $response = [
                'id' => $article['id']
                ,'title' => $article['title']
                ,'sefName' => $article['sef_name']
                ,'subHeading' => $article['sub_heading']
                ,'path' => isDesktop() ? makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'], $articleLocation['categorySefName'], $article['sef_name'] ] ) : makeArticleLink($articleLocation['subChannelId'], $articleLocation['categoryId'], $article['id'])
                ,'isAdvert' => false
                ,'published' => dateFormat($article['published'])
                ,'displayType' => [
                    'id' => $articleLocation['displayTypeId']
                    ,'type' => $articleLocation['displayType']
                ]
                ,'displayStyle' => ! isset( $article['display_style'] ) ? 1 : $article['display_style']
                ,'assignment' => [
                    'channel' => [
                        'id' => $articleLocation['channelId']
                        ,'name' => $articleLocation['channelName']
                        ,'sefName' => $articleLocation['channelSefName']
                        ,'path' => isDesktop() ? makePath( [ $articleLocation['channelSefName'] ] ) : makeChannelLink($articleLocation['channelId'])
                    ]
                    ,'subChannel' => [
                        'id' => $articleLocation['subChannelId']
                        ,'name' => $articleLocation['subChannelName']
                        ,'sefName' => $articleLocation['subChannelSefName']
                        ,'path' => isDesktop() ? makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'] ] ) : makeSubChannelPath($articleLocation['subChannelId'], $articleLocation['displayType'])
                    ]
                    ,'category' => [
                        'id' => $articleLocation['categoryId']
                        ,'name' => $articleLocation['categoryName']
                        ,'sefName' => $articleLocation['categorySefName']
                        ,'path' => isDesktop() ? makePath( [ $articleLocation['channelSefName'], $articleLocation['subChannelSefName'], $articleLocation['categorySefName'] ] ) : makeCategoryPath($articleLocation['categoryId'], $articleLocation['displayType'], $articleLocation['subChannelId'])
                    ]                    
                ]          
            ];

            // init an empty media array even if there is no asset attached the current item
            $response['media'] = null;

            if( isset($article['asset'][0]) )
            {
                $articleAsset = $article['asset'][0];

                $response['media'] = [
                    'filepath' => $articleAsset['filepath']
                    ,'alt' => $articleAsset['alt']
                    ,'title' => $articleAsset['title']
                    ,'width' => $articleAsset['width']
                    ,'height' => $articleAsset['height']
                ];
            }   

            // If there is an event then transform that as well

            if( isset($article['event']['id']) )
            { 
                $eventTransformer = App::make( 'EventTransformer' );

                $response['event'] = $eventTransformer->transform( $article['event'] );
            }
            // venues can be attached to articles without an event (ref directory type article)
            elseif (isset($article['venue']['id']))
            {
                $response['venue'] = App::make( 'VenueTransformer' )->transform( $article['venue'] );                
            }           

            // remove anything that only the desktop version needs

            if( isMobile() && ! isset($options['ignorePlatform']) ) // but only do this when this option isn't around. This prevents content hiding when its in fact needed, namely in the case of the HTML template creation on the front end.
            {
                unset($response['sefName']);
                unset($response['path']);
                unset($response['assignment']['channel']['sefName']);
                unset($response['assignment']['subChannel']['sefName']);
                unset($response['assignment']['category']['sefName']);
                unset($response['assignment']['channel']['path']);
                unset($response['assignment']['subChannel']['path']);
                unset($response['assignment']['category']['path']);                
                unset($response['event']['venue']['sefName']);
                unset($response['event']['detail']['sefName']);
                unset($response['event']['detail']['url']);
                unset($response['media']['alt']);
                unset($response['media']['title']);
                unset($response['media']['width']);
                unset($response['media']['height']);
            }

            return $response;
        }
    }
}