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
        $this->eventDay = isset($options['eventDay']) ? $options['eventDay'] : $this->getFirstFromList($this->times);

        // now create a summary object
        $response = [
            'summary' => [
                'isMultiDate' => count($this->times) > 1 ? true : false,
                'firstPerformance' => $this->getFirstPerformance(),
                'nextPerformance' => $this->getNextPerformance(),
                'lastPerformance' => $this->setLastPerformance(),
            ],
            'times' => $this->times
        ];

        $this->setThisPerformance();

        return $response;
    }

    /**
     * Work out which is the current performance using the performance date
     *
     * @return array
     */
    public function setThisPerformance()
    {     
       if( count($this->times) > 1 )
       {         
            foreach( $this->times AS $key => $performance )
            {   
                $this->getPerformance($performance);
            }        
       }
        else
        {       
            if(isset($this->times[0])) {
                $this->performance = $this->times[0];    
            }            
        }        

        return $this->first = $this->setPerformance();
    }

    /**
     * Calculate which is the earliest performance based on the timestamp of the performance
     *
     * @param array $performance
     * @return null
     */
    public function getPerformance($performance)
    {    
        ## on the current event day find the first performance time
        if(strtotime($this->eventDay) == strtotime($performance['start']['day']))
        {
            # set the earliest performance to the first that we get if nothing has been set before
            if( is_null($this->performance) ) {
                $this->performance = $performance;
            }
           # compare the start time of the incoming performance with that stored. If its earlier then store the new one
            else if((int) $performance['start']['epoch'] < (int) $this->performance['start']['epoch']) {                
                $this->performance = $performance;    
            }
        }
    }

    /**
     * Work out which is the last performance using the performance date
     *
     * @return array
     */
    public function setLastPerformance()
    {
        foreach( $this->times AS $key => $performance )
        {   
            $this->getLastPerformance($performance);
        } 

        return $this->last = $this->setPerformance();
    }

    /**
     * Create and set the parameters of a performance object
     *
     * @return stdClass
     */
    public function setPerformance($type="")
    {
        $event = [];

        $event['start'] = $this->performance['start']['day'];
        $event['time'] = $this->performance['start']['time'];
        $event['epoch'] = $this->performance['start']['epoch'];
        $event['price'] = $this->performance['price'];

        return $event;
    }

    public function getFirstFromList($days)
    {   
        $tmp = null;
        foreach($days AS $day)
        {
            if(is_null($tmp)) {
                $tmp = $day;
            }
            else if($day['start']['epoch'] < $tmp['start']['epoch']) 
            {   
                $tmp = $day;
            }
        }

        return $tmp['start']['day'];
    }

    /**
     * Go through the list of performances and work out which was the very first
     * 
     * @return null
     */
    public function getFirstPerformance()
    {
        $tmp = null;

        foreach( $this->times AS $key => $performance )
        {              
            if(is_null($tmp)) {
                $tmp = $performance;
            }
            else if($performance['start']['epoch'] < $tmp['start']['epoch']) {
                $tmp = $performance;   
            }
        } 

        $this->performance = $tmp;

        return $this->setPerformance();
    }

    /**
     * Using the current eventDay, work out which performance out of the list of several is happening "today"
     * 
     * @return null
     */
    public function getNextPerformance($time = null)
    {
        if(is_null($time)) {
            $time = strtotime(date('Y-m-d', time()));
        }        

        // we are going over events in the future so do that
        if(strtotime($this->eventDay) > $time)
        {           
            return $this->getNextDaysPerformance();
        }

        # other wise see which is the next event today
        foreach( $this->times AS $key => $performance )
        {    
            if($performance['start']['epoch'] >= time() && $performance['start']['day'] == date('Y-m-d') )
            {
                $this->performance = $performance;    

                break;            
            }
        } 

        return $this->setPerformance();
    }

    /** 
     * grab the first performance time that occurs in the times array for the given day
     * 
     * @return array [first instance of a performance on a chosen day]
     */
    public function getNextDaysPerformance()
    { 
        # go through our times array and find the first performance on the chosen event day        
        foreach( $this->times AS $key => $performance )
        {    
            if( $performance['start']['day'] == $this->eventDay)
            {   
                $this->performance = $performance;    
                
                return $this->setPerformance('next');            
            }
        } 
    }

    /**
     * Work out which is the last in the list of performances for this event
     * 
     * @param  array $performance
     * @return null
     */
    public function getLastPerformance($performance)
    {
        if($performance['start']['epoch'] > $this->performance['start']['epoch']) 
        {
            $this->performance = $performance;   
        }
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
