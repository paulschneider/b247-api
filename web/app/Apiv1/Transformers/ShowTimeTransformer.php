<?php namespace Apiv1\Transformers;

use Config;
use stdClass;

class ShowTimeTransformer extends Transformer {

    /**
     * formatted array of show times
     * 
     * @var array
     */
    public $times = [];

    /**
     * The listing event day
     * @var string
     */
    public $eventDay;

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $showTime, $options = [] )
    {
        
    }

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $showTimes, $options = [] )
    {
        $this->times = [];

        ### grab the passed through event day. We need this to work out which performance is happening today
        ### out of the list of performances we will transform
        $this->eventDay = $options['eventDay'];


        // go through each of the show times and transform them into something usable
        foreach($showTimes AS $performance)
        {
            $this->times[] = [
                'start' => [
                    'epoch' => strtotime($performance['showtime']),
                    'readable' => $this->performanceDateFormatter($performance['showtime']),
                    'day' => date('Y-m-d', strtotime($performance['showtime']))
                ],
                'end' => [
                    'epoch' => strtotime($performance['showend']),
                    'readable' => $this->performanceDateFormatter($performance['showend']),
                    'day' => date('Y-m-d', strtotime($performance['showend']))
                ],
                'price' => number_format( $performance['price'], 2 )
            ];
        }

        return $this;
    }

    public function first()
    {
        $event = new stdClass();
    
        foreach( $this->times AS $performance )
        {            
            if($performance['start']['day'] == $this->eventDay)
            {
                sd($performance);
            }
        }
    }

    public function performanceDateFormatter($dateTime)
    {
        return date('d-m-Y H:i', strtotime($dateTime));
    }
}
