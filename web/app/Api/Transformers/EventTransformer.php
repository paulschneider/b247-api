<?php namespace Api\Transformers;

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
    public function transform( $event, $options = [] )
    {
        if( ! is_array($event))
        {
            $event = $event->toArray();
        }

        $venue = $event['venue'];
        unset($event['venue']);
        $venueTransformer = \App::make( 'VenueTransformer' );                

        return [
            'details' => [
                'id' => $event['id']
                ,'title' => $event['title']
                ,'sefName' => $event['sef_name']
                ,'showDate' => $event['show_date']
                ,'showTime' => $event['show_time']
                ,'epoch' => strtotime( $event['show_date'] . ' ' . $event['show_time'] )
                ,'price' => number_format( $event['price'], 2 )
                ,'url' => $event['url']
            ]
            ,'venue' => $venueTransformer->transform( $venue )
        ];
    }
}