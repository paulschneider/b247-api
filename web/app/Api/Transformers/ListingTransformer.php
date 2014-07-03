<?php namespace Api\Transformers;

use Api\Transformers\ArticleTransformer;
use Api\Transformers\EventTransformer;

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

        $articleTransformer = new ArticleTransformer;
        $eventTransformer = new EventTransformer;
        $limitToShowPerDay = 999;   
        $categoryCounter = [];

        if( isset($options['perDayLimit']) )
        {
            $limitToShowPerDay = $options['perDayLimit'];
        }

        foreach( $articles AS $article )
        {
            $hasEvent = false;

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
                ,'path' => makePath( [ $location['channelSefName'], $location['subChannelSefName'], $location['categorySefName'] ] )
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

            if( ! isset($response[ $key ]['articles']) )
            {
                $response[ $key ]['articles'] = [];
            }

            if( ! is_null($limitToShowPerDay) && count($response[ $key ]['articles']) < $limitToShowPerDay )
            {
                $response[ $key ]['articles'][] = $article;
            }

            // if an array of picked items was sent through then we want to go through each one and attach it to the right day

            if( isset($options['picks']) )
            {
                foreach($options['picks'] AS $pick)
                {
                    // work out which day to append the article to
                    $id = date('d-m-Y', strtotime($pick['published']));

                    // transform and then append it
                    $response[ $key ]['picks'][] = $articleTransformer->transform($pick, [ 'showBody' => false] );
                }
            }
        }

        return array_values($response);
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
