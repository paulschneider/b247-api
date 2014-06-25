<?php namespace Api\Transformers;

use Api\Transformers\EventTransformer;

class ArticleTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transformCollection( $articles, $options = [] )
    {
        $response = [];

        foreach($articles AS $article)
        {
            $tmp = $this->transform($article, $options);

            $response[] = $tmp;
        }
        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        if( isset($article['location'][0]) and isset($article['asset'][0]) )
        {
            $articleLocation = $article['location'][0];
            $articleAsset = $article['asset'][0];

            $response = [
                'id' => $article['id']
                ,'title' => $article['title']
                ,'sefName' => $article['sef_name']
                ,'subHeading' => $article['sub_heading']
                ,'body' => $article['body']
                ,'path' => $articleLocation['channelSefName'] . '/' . $articleLocation['subChannelSefName'] . '/' . $articleLocation['categorySefName'] . '/' . $article['sef_name']
                ,'isAdvert' => false
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
                    ]
                    ,'subChannel' => [
                        'id' => $articleLocation['subChannelId']
                        ,'name' => $articleLocation['subChannelName']
                        ,'sefName' => $articleLocation['subChannelSefName']
                    ]
                    ,'category' => [
                        'id' => $articleLocation['categoryId']
                        ,'name' => $articleLocation['categoryName']
                        ,'sefName' => $articleLocation['categorySefName']
                    ]
                ]
                ,'media' => [
                    'filepath' => $articleAsset['filepath']
                    ,'alt' => $articleAsset['alt']
                    ,'title' => $articleAsset['title']
                    ,'width' => $articleAsset['width']
                    ,'height' => $articleAsset['height']
                ]
            ];

            // If there is an event then transform that as well

            if( isset($article['event']) )
            {
                $eventTransformer = new EventTransformer();

                $response['event'] = $eventTransformer->transform( $article['event'] );
            }

            // remove anything that only the desktop version needs

            if( ! isDesktop() )
            {
                unset($response['sefName']);
                unset($response['path']);
                unset($response['assignment']['channel']['sefName']);
                unset($response['assignment']['subChannel']['sefName']);
                unset($response['assignment']['category']['sefName']);
                unset($response['media']['alt']);
                unset($response['media']['title']);
                unset($response['media']['width']);
                unset($response['media']['height']);
                unset($response['event']['venue']['sefName']);
                unset($response['event']['detail']['sefName']);
                unset($response['event']['detail']['url']);
            }

            if ( isset($options['showBody']) && ! $options['showBody'] )
            {
                unset($response['body']);
            }

            return $response;
        }
    }
}
