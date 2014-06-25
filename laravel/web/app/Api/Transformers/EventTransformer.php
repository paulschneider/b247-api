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

        return [
            'details' => [
                'id' => $event['id']
                ,'title' => $event['title']
                ,'sefName' => $event['sef_name']
                ,'showDate' => $event['show_date']
                ,'showTime' => $event['show_time']
                ,'price' => $event['price']
                ,'url' => $event['url']
            ]
            ,'venue' => [
                'id' => $venue['id']
                ,'name' => $venue['name']
                ,'sefName' => $venue['sef_name']
                ,'address1' => $venue['address_line_1']
                ,'address2' => $venue['address_line_2']
                ,'address3' => $venue['address_line_3']
                ,'postcode' => $venue['postcode']
                ,'email' => $venue['email']
                ,'facebook' => $venue['facebook']
                ,'twitter' => $venue['twitter']
                ,'phone' => $venue['phone']
                ,'lat' => $venue['lat']
                ,'lon' => $venue['lon']
            ]
        ];
    }
}
