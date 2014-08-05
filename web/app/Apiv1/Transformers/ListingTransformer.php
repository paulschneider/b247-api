<?php namespace Apiv1\Transformers;

Class ListingTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     * These function are all about grouping articles by a date parameter. They look similar but do different things
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $articles, $options = [] )
    {
        $response = [];

        $articleTransformer = \App::make('ArticleTransformer');
        $eventTransformer = \App::make('EventTransformer');
        $categoryTransformer = \App::make('CategoryTransformer');
        
        $limitToShowPerDay = 100;   
        $categoryCounter = [];

        if( isset($options['perDayLimit']) )
        {
            $limitToShowPerDay = $options['perDayLimit'];
        }

        // grab the days array. This is an empty array with the keys set to the coming seven days
        if( isset($options['days']) )
        {
            $days = $options['days'];
        }
        else
        {
            sd('The required DAYS array has not been provided to ListingTransformer::transformCollection()');
        }

        foreach( $days AS $key => $day )
        {
            $date = $key;

            $days[$date]['publication'] = [
                'date' => $date,
                'day' => date('D', strtotime($date)),
                'fullDay' => date('l', strtotime($date)),
                'iso8601Date' => date('c', strtotime($date)),
                'epoch' => strtotime($date),
            ]; 

            $days[$date]['categories'] = [];
            $days[$date]['articles'] = [];
        }

        foreach( $articles AS $article )
        {
            // default event flag
            $hasEvent = false;

            // grab the article location
            $location = $article['location'][0];

            // convert the publication date to a dateStamp
            $day = date('Y-m-d', strtotime($article['published']));

            $categoryCounter[ $day ][$location['categoryId']][] = $location['categoryId'];

            $days[ $day ]['categories'][$location['categoryId']] = [
                'id' => $location['categoryId'],
                'name' => $location['categoryName'],
                'sefName' => $location['categorySefName'],
                'path' => makePath( [ $location['channelSefName'], $location['subChannelSefName'], $location['categorySefName'] ] ),
                'numberOfArticles' => count($categoryCounter[ $day ][$location['categoryId']]),
            ];

            if( isset($article['event']) )
            {
                $event = $eventTransformer->transform( $article['event'] );

                $hasEvent = true;
            }

            $article = $articleTransformer->transform($article);

            if( $hasEvent )
            {
                $article['event'] = $event;
            }

            if( ! isset($days[ $day ]['articles']) )
            {
                $days[ $day ]['articles'] = [];
            }

            // if a limit has been passed through for each day then only add that number of articles to the return for that day

            if( count($days[ $day ]['articles']) < $limitToShowPerDay )
            {
                $days[ $day ]['articles'][] = $article;
            }
        }

        // once we're done reset the array keys for the category listing
        foreach( $days AS $key => $day )
        {
            // if we added some articles then we also added some categories. Reset those array keys to integers
            if( isset($days[$key]['categories']) )
            {
                $days[$key]['categories'] = array_values($day['categories']);    
            }            
        }

        // no reset all top level array keys and return the result
        return array_values($days);
    }

    /**
     * Transform a single listing day object into the API required format. These function are all about grouping articles by a date parameter. They look similar but do different things
     *
     * @param sponsor
     * @return array
     */
    public function transform( $articles, $options = [] )
    {
        $response = [];

        $articleTransformer = \App::make('ArticleTransformer');
        $eventTransformer = \App::make('EventTransformer');
        $categoryTransformer = \App::make('CategoryTransformer');

        $highlightsToShow = 3;   
        $categoryCounter = [];

        foreach( $articles AS $article )
        {
            // we'll check for this later once the article has been transformed
            $hasEvent = false;

            // grab the location array from the article
            $location = $article['location'][0];

            // we'll use the published date of the article to group them for the listing
            $key = date('d-m-Y', strtotime($article['published']));

            // we need to build up a count of articles in each category. this does that
            $categoryCounter[ $key ][$location['categoryId']][] = $location['categoryId'];

            $response[ $key ]['publication'] = [
                'date' => $article['published']
                ,'day' => date('D', strtotime($article['published']))
                ,'fullDay' => date('l', strtotime($article['published']))
                ,'iso8601Date' => date('c', strtotime($article['published']))
                ,'epoch' => strtotime($article['published'])
            ];

            $response[ $key ]['categories'][$location['categoryId']] = [
                'id' => $location['categoryId']
                ,'name' => $location['categoryName']
                ,'sefName' => $location['categorySefName']
                ,'path' => makePath( [ $location['channelSefName'], $location['subChannelSefName'], $location['categorySefName'] ] )
                ,'numberOfArticles' => count($categoryCounter[ $key ][$location['categoryId']])
            ];

            if( isset($article['event']) )
            {
                $event = $eventTransformer->transform( $article['event'] );

                $hasEvent = true;
            }
            // this will get over-written in the articleTransformer. so we'll store it and check for it later
            $articleIsPicked = $article['is_picked'];

            // transform the article into a nicer object for the API response
            $article = $articleTransformer->transform($article, [ 'showBody' => false] );

            // if there was an event we now want to attach it to the article
            if( $hasEvent )
            {
                $article['event'] = $event;
            }

            // initialise the picks array for the day
            if( ! isset($response[ $key ]['picks']) )
            {
                $response[ $key ]['picks'] = [];
            }

            // initialise the articles array for the day
            if( ! isset($response[ $key ]['articles']) )
            {
                $response[ $key ]['articles'] = [];
            }

            // we want to separate out the first few picks articles into a separate array. Do this until we reach the currently set limit
            if( $articleIsPicked && count($response[ $key ]['picks']) < $highlightsToShow )
            {
                $response[ $key ]['picks'][] = $article;
            }
            // otherwise pipe the article into the main articles array
            else
            {
                $response[ $key ]['articles'][] = $article;    
            }
        }
        
        // once we're done reset the array keys for the category listing
        foreach( $response AS $key => $day )
        {
            $response[$key]['categories'] = array_values($day['categories']);
        }

         return array_values($response);
    }
}