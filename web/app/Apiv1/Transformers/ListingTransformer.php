<?php namespace Apiv1\Transformers;

use App;

Class ListingTransformer extends Transformer {

    public $days;

    public $articlesToShowEachDay;

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
        
        $this->articlesToShowEachDay = 100;           

        if( isset($options['perDayLimit']) ) {
            $this->articlesToShowEachDay = $options['perDayLimit'];
        }

        // grab the days array. This is an empty array with the keys set to the coming seven days
        if( isset($options['days']) ) {
            $days = $options['days'];
        }
        else {
            sd('The required DAYS array has not been provided to ListingTransformer::transformCollection()');
        }

        // go through each of the days supplied, format and assign any articles
        foreach( $days AS $key => $day )
        {
            $date = $key;

            $this->days[$date]['publication'] = [
                'date' => $date,
                'day' => date('D', strtotime($date)),
                'fullDay' => date('l', strtotime($date)),
                'iso8601Date' => date('c', strtotime($date)),
                'epoch' => strtotime($date),
            ]; 

            $this->days[$date]['categories'] = null;
            $this->days[$date]['articles'] = null;

            // now grab the articles for the given day
            $this->getArticlesForAGivenDay($articles, $date, $options);
        }        

        // once we're done reset the array keys for the category listing
        foreach( $this->days AS $key => $day )
        {
            // if we added some articles then we also added some categories. Reset those array keys to integers
            if( isset($this->days[$key]['categories']) )
            {
                $this->days[$key]['categories'] = array_values($day['categories']);    
            }            
        }

        // no reset all top level array keys and return the result
        return array_values($this->days);
    }

    public function getArticlesForAGivenDay($articles, $day, array $options)
    {
        $categoryCounter = [];       

        foreach( $articles AS $article )
        {    
            # grab the article location before it gets transformed (and removed)
            $location = $article['location'][0];

            $article = App::make('ArticleTransformer')->transform($article, [ 'showBody' => false, 'eventDay' => $day ]);

            # if a limit has been passed through for each day then only add that number of articles to the return for that day

            if( count($this->days[ $day ]['articles']) < $this->articlesToShowEachDay && $article['event']['details']['showDate'] == $day )
            {              
                $categoryCounter[ $day ][$location['categoryId']][] = $location['categoryId'];

                $this->days[ $day ]['categories'][$location['categoryId']] = [
                    'id' => $location['categoryId'],
                    'name' => $location['categoryName'],
                    'sefName' => $location['categorySefName'],
                    'path' => makePath( [ $location['channelSefName'], $location['subChannelSefName'], $location['categorySefName'] ] ),
                    'numberOfArticles' => count($categoryCounter[ $day ][$location['categoryId']]),
                ];

                $this->days[$day]['articles'][] = $article;
            }
        }
    }

    /**
     * Transform a single listing day object into the API required format. 
     * These function are all about grouping articles by a date parameter. 
     * They look similar but do different things
     *
     * @param sponsor
     * @return array
     */
    public function transform( $articles, $options = [] )
    { 
        $day = $options['day'];

        $response = [];

        $highlightsToShow = 3;   
        $categoryCounter = [];

        # always provide some meta data about what we're doing
        $response[ $day ]['publication'] = [
            'date' => $day
            ,'day' => date('D', strtotime($day))
            ,'fullDay' => date('l', strtotime($day))
            ,'iso8601Date' => date('c', strtotime($day))
            ,'epoch' => strtotime($day)
        ];

        $response[ $day ]['categories'] = [];
        $response[ $day ]['articles'] = [];

        foreach( $articles AS $article )
        {
            // we'll check for this later once the article has been transformed
            $hasEvent = false;

            // grab the location array from the article
            $location = $article['location'][0];

            // we need to build up a count of articles in each category. this does that
            $categoryCounter[ $day ][$location['categoryId']][] = $location['categoryId'];            

            $response[ $day ]['categories'][$location['categoryId']] = [
                'id' => $location['categoryId']
                ,'name' => $location['categoryName']
                ,'sefName' => $location['categorySefName']
                ,'path' => makePath( [ $location['channelSefName'], $location['subChannelSefName'], $location['categorySefName'] ] )
                ,'numberOfArticles' => count($categoryCounter[ $day ][$location['categoryId']])
            ];

            // this will get over-written in the articleTransformer. so we'll store it and check for it later
            $articleIsPicked = $article['is_picked'];

            // transform the article into a nicer object for the API response
            $article = App::make('ArticleTransformer')->transform($article, [ 'showBody' => false, 'eventDay' => $day ] );

            // initialise the picks array for the day
            if( ! isset($response[ $day ]['picks']) ) {
                $response[ $day ]['picks'] = [];
            }

            # initialise the articles array for the day
            if( ! isset($response[ $day ]['articles']) ) {
                $response[ $day ]['articles'] = [];
            }

            # we want to separate out the first few picks articles into a separate array. Do this until we reach the currently set limit
            # as long as it has a showDate!
            if( $articleIsPicked && count($response[ $day ]['picks']) < $highlightsToShow && isset($article['event']['details']['showDate']) && ! is_null($article['event']['details']['showDate'])) {
                $response[ $day ]['picks'][] = $article;
            }
            # otherwise pipe the article into the main articles array, as long as it has a showDate!
            else if( isset($article['event']['details']['showDate']) && ! is_null($article['event']['details']['showDate']) ) {
                $response[ $day ]['articles'][] = $article;    
            }
        }

        # once we're done reset the array keys for the category listing
        foreach( $response AS $key => $item ) {
            $response[$key]['categories'] = array_values($item['categories']);
        }

        return array_values($response);
    }
}