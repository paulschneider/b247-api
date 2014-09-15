<?php namespace Apiv1\Transformers;

use App;
use Config;
use stdClass;
use Carbon\Carbon;

class ShowTimeTransformer extends Transformer {

    /**
     * The article to which this event is attached
     * 
     * @var Apiv1\Repositories\Articles\Article
     */
    public $article;

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
    public function transformCollection( $article, $options = [] )
    {
        # let the class know about this article
        $this->article = $article;

        $this->times = [];       

        // go through each of the show times and transform them into something usable
        foreach($article['event']['show_time'] AS $performance)
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

        # now create a summary object
        $response = [
            'summary' => [
                'isMultiDate' => false,
                'fromPrice' => $this->getLowestPerformancePrice(),
                'firstPerformance' => $this->getFirstPerformance(),
                'showingToday' => $this->getTodaysPerformances()
            ],
        ];

        if(count($this->times) > 1) {            
            $response['summary']['nextPerformance'] = $this->getNextPerformance();
            $response['summary']['lastPerformance'] = $this->getLastPerformance();                             
            $response['summary']['isMultiDate'] = $this->isMultiDate($response['summary']['firstPerformance'], $response['summary']['lastPerformance']);
        }

        # regardless of how many shows there are, add in the venue data
        $response['summary']['venue'] = $this->getVenue();

        # ... and return it all
        return $response;
    }

    /**
     * check to see whether this show runs across multiple days
     * 
     * @param  array  $firstPerformance [details of the very first performance of this show]
     * @param  array  $lastPerformance  [details of the very last performance of this show]
     * @return boolean
     */
    public function isMultiDate($firstPerformance, $lastPerformance)
    {
        # convert the start day of the first performance and last performance
        # if the first day is less than the last day then its a multi-date performance
        if(strtotime($firstPerformance['start']['day']) < strtotime($lastPerformance['start']['day']))
        {
            return true;
        }

        // its on the same day
        return false;
    }

    /**
     * retrieve the venue for the event
     * 
     * @return array $venue
     */
    public function getVenue()
    {
        if(isset($this->article['event']['show_time'][0]['venue']))
        {
            $venue = $this->article['event']['show_time'][0]['venue'];

            return App::make('VenueTransformer')->transform( $venue );    
        }        
    }

    public function getTodaysPerformances()
    {
        if(count($this->times) > 0)
        {
            $today = date('Y-m-d');
             $kept = [];

            foreach($this->times AS $show)
            {
                if($show['start']['day'] == $today)
                {
                    $kept[$show['start']['epoch']] = $show;
                }
            }
            
            ksort($kept);

            return array_values($kept);
        }

        return null;
    }

    public function getNextPerformance()
    {
        foreach($this->times AS $time)
        {
            if(strtotime($time['start']['day']) == strtotime($this->eventDay))
            {
                return $time;
            }
        }
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

    /**
     * Work out which is the last performance using the performance date
     *
     * @return array
     */
    public function getLastPerformance()
    {
        if( ! is_null($this->eventDay) )
        {
            $tmp = 0;

            $eventDay = strtotime($this->eventDay . ' 00:00:01');

            foreach( $this->times AS $time )
            {   
                if($time['start']['epoch'] > $eventDay)
                {
                    $tmp = $time;
                }            
            }    
        }

        $tmp = 0;

        foreach( $this->times AS $time )
        {
            if(isset($tmp['start']['epoch']) && $time['start']['epoch'] > $tmp['start']['epoch']) {
                $tmp = $time;
            } 
            else {
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
            if( ! array_key_exists($time['start']['epoch'], $sortedTimes) )
            {
                $sortedTimes[$time['start']['epoch']] = $time;    
            }
            
        }
        ksort($sortedTimes);

        $this->times = array_values($sortedTimes);
    }

    /**
     * go through each of the performances and work out which the cheapest. This will be shown
     * on the front end as the 'from £' price
     * 
     * @return string [the lowest priced performance in this performance run]
     */
    public function getLowestPerformancePrice()
    {
        $tmp = 10000;

        foreach($this->times AS $performance)
        {
            if($performance['price'] < $tmp)
            {
                $tmp = $performance['price'];
            }
        }

        return $tmp == 10000 ? '0.00' : $tmp;
    }
}
