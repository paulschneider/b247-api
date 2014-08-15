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
            $performances = App::make( 'Apiv1\Transformers\ShowTimeTransformer' )->transformCollection($article['event']['show_time'], $options);    

            $showDate = $performances['summary']['nextPerformance']['start']['day'];
            $showTime = $performances['summary']['nextPerformance']['start']['time'];
            $epoch = strtotime($performances['summary']['nextPerformance']['start']['day'] .' ' . $performances['summary']['nextPerformance']['start']['time']);
            $price = $performances['summary']['nextPerformance']['price'];
        }
        else 
        {
            $performances = App::make('Apiv1\Transformers\CinemaListingTransformer')->transform($article, $options);

            $showDate = $performances['summary']['startTime']['day'];
            $showTime = $performances['summary']['startTime']['time'];
            $epoch = $performances['summary']['startTime']['epoch'];
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