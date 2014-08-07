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

        $performances = App::make( 'Apiv1\Transformers\ShowTimeTransformer' )->transformCollection($article['event']['show_time'], $options);

        $response = [
            'details' => [
                'id' => $event['id']
                ,'title' => $event['title']
                ,'sefName' => $event['sef_name']
                ,'showDate' => $performances['summary']['nextPerformance']['start']
                ,'showTime' => $performances['summary']['nextPerformance']['time']
                ,'price' => $performances['summary']['nextPerformance']['price']
                ,'url' => $event['url']
                ,'performances' => $performances
            ]
            ,'venue' => App::make( 'VenueTransformer' )->transform( $venue )
        ];

        return $response;
    }
}