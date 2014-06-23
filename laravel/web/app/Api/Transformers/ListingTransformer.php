<?php namespace Api\Transformers;

class ListingTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $articles, $options = [] )
    {
        $response = [];

        $articleTransformer = $options['articleTransformer'];
        $eventTransformer = $options['eventTransformer'];

        $articles = $articles->toArray();

        $categoryCounter = [];

        foreach( $articles AS $article )
        {
            $hasEvent = false;

            if( isset($article['location'][0]['locationId']) )
            {
                $location = $article['location'][0];

                $key = date('d-m-Y', strtotime($article['published']));

                $categoryCounter[ $key ][$location['categoryId']][] = $location['categoryId'];

                $response[ $key ]['publication'] = [
                    'date' => $article['published']
                    ,'day' => date('D', strtotime($article['published']))
                    ,'fullDay' => date('l', strtotime($article['published']))
                    ,'iso8601Date' => date('c', strtotime($article['published']))
                    ,'epoch' => strtotime($article['published'])
                ];

                $response[ $key ]['categories'][$location['categoryId']] = [
                    'categoryId' => $location['categoryId']
                    ,'categoryName' => $location['categoryName']
                    ,'categorySefName' => $location['categorySefName']
                    ,'path' => $location['channelSefName'] . '/' . $location['subChannelSefName'] . '/' . $location['categorySefName']
                    ,'count' => count($categoryCounter[ $key ][$location['categoryId']])
                ];

                if( isset($article['event']) )
                {
                    $event = $eventTransformer->transform( $article['event'] );

                    $hasEvent = true;
                }

                $article = $articleTransformer->transform($article, [ 'showBody' => false] );

                if( $hasEvent )
                {
                    $article['event'] = $event;
                }

                $response[ $key ]['articles'][] = $article;
            }
        }

        return $response;
    }

    /**
     * Transform a single result into the API required format
     *
     * @param sponsor
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        // do something eventually
    }
}
