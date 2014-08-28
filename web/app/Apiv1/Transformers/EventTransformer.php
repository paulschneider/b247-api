<?php namespace Apiv1\Transformers;

use App;

class EventTransformer extends Transformer {

    /**
     * Transform a result set into the API required format
     *
     * @param sponsors
     * @return array
     */
    public function transformCollection( $events, $options = [] )
    {
        $response = [];

        foreach( $events AS $event )
        {
            $response[] = $this->transform( $event, $options );
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
        $venue = $article['event']['venue'];
        $event = $article['event'];
        unset($article['event']['venue']);        

        if( empty($article['event']['cinema']) ) 
        {
            $performances = App::make( 'Apiv1\Transformers\ShowTimeTransformer' )->transformCollection($article, $options);    

            # if we don't have any performances to work with then just return out of this process
            if(! $performances) {
                return false;
            }

            # work out which performance to use as the primary data source
            # if its multi-date use the next available performance
            if(isset($performances['summary']['nextPerformance'])) {
                $performance = $performances['summary']['nextPerformance'];
            }
            # if its single date then just use that one
            else {
                $performance = $performances['summary']['firstPerformance'];   
            }

            $showDate = $performance['start']['day'];
            $showTime = $performance['start']['time'];
            $epoch = strtotime($performance['start']['day'] .' ' . $performance['start']['time']);
            $price = $performance['price'];
        }
        else 
        {
            $performances = App::make('Apiv1\Transformers\CinemaListingTransformer')->transform($article, $options);

            $showDate = $performances['summary']['show']['startTime']['day'];
            $showTime = $performances['summary']['show']['startTime']['time'];
            $epoch = $performances['summary']['show']['startTime']['epoch'];
            $price = $performances['summary']['price'];
        }        

        $response = [
            'details' => [
                'id' => $event['id'],
                'title' => $event['title'],
                'sefName' => $event['sef_name'],
                'showDate' => $showDate,
                'showTime' => $showTime,
                'epoch' => $epoch,
                'price' => $price,
                'url' => $event['url'],
                'performances' => $performances
            ]
            ,'venue' => App::make( 'VenueTransformer' )->transform( $venue )
        ];

        return $response;
    }
}