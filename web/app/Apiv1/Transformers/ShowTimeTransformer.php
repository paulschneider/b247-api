<?php namespace Apiv1\Transformers;

use Config;
use stdClass;
use Carbon\Carbon;

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
     * Performance details
     * @var array
     */
    public $performance;

    /**
     * list of performances for this event
     * @var array
     */
    public $list = [];

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $showTime, $options = [] )
    {
        // to do
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

        // go through each of the show times and transform them into something usable
        foreach($showTimes AS $performance)
        {
            $this->times[] = [
                'start' => [
                    'epoch' => strtotime($performance['showtime']),
                    'readable' => $this->performanceDateFormatter($performance['showtime']),
                    'day' => date('Y-m-d', strtotime($performance['showtime'])),
                    'time' => date('H:i', strtotime($performance['showtime']))
                ],
                'end' => [
                    'epoch' => strtotime($performance['showend']),
                    'readable' => $this->performanceDateFormatter($performance['showend']),
                    'day' => date('Y-m-d', strtotime($performance['showend'])),
                    'time' => date('H:i', strtotime($performance['showend']))
                ],
                'price' => number_format( $performance['price'], 2 )
            ];
        }

        $this->sort($this->times);

         ### grab the passed through event day. We need this to work out which performance is happening today
        ### out of the list of performances we will transform
        
        $this->eventDay = isset($options['eventDay']) ? $options['eventDay'] : null;

        // now create a summary object
        $response = [
            'summary' => [
                'isMultiDate' => count($this->times) > 1 ? true : false,
                'firstPerformance' => $this->getFirstPerformance(),
                'nextPerformance' => $this->getNextPerformance(),
                'lastPerformance' => $this->getLastPerformance(),
            ],
        ];

        return $response;
    }

    /**
     * Go through the list of performances and work out which was the very first
     * 
     * @return null
     */
    public function getFirstPerformance()
    {
        $tmp = 0;

        foreach( $this->times AS $key => $performance )
        {              
            if($tmp == 0) {
                $tmp = $performance;
            }
            else if($performance['start']['epoch'] < $tmp['start']['epoch']) {
                $tmp = $performance;   
            }
        } 
       
        return $tmp;
    }

    public function getNextPerformance()
    {
        $tmp = 0;

        $eventDay = strtotime($this->eventDay . ' 00:00:01');

        foreach($this->times AS $time)
        {
            if($time['start']['epoch'] > $eventDay  )
            {
                return $time;
            }
        }
    }

    /**
     * Work out which is the last performance using the performance date
     *
     * @return array
     */
    public function getLastPerformance()
    {
        $tmp = 0;

        $eventDay = strtotime($this->eventDay . ' 00:00:01');

        foreach( $this->times AS $key => $time )
        {   
            if($time['start']['epoch'] > $eventDay)
            {
                $tmp = $time;
            }            
        } 

        return $tmp;
    }

    /**
     * Format a timestamp to the class required format
     * 
     * @param  int $dateTime [unix timestamp]
     * @return array [formatted date / timestamp]
     */
    public function performanceDateFormatter($dateTime)
    {
        return date('Y-m-d H:i', strtotime($dateTime));
    }

    /**
     * Sort the time array by the epoch to put them in chronological order
     * 
     * @param  array $times [array of time arrays as created by TransformCollection()]
     * @return array        [chronologically sorted times array]
     */
    public function sort($times)
    {
        $sortedTimes = [];

        foreach($times AS $time)
        {
            $sortedTimes[$time['start']['epoch']] = $time;
        }
        ksort($sortedTimes);

        $this->times = array_values($sortedTimes);
    }
}
