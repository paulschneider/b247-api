<?php namespace Apiv1\Transformers;

use App;
use stdClass;

Class CinemaListingTransformer extends Transformer {

    private $eventDay = null;

    public $article;
    public $venues;
    public $isMultiDate;

    /**
     * Transform a result set into the API required format
     *
     * @param users
     * @return array
     */
    public function transformCollection( $article, $options = [] )
    {
        // To do
    }

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        # make the articles available to the class
        $this->article = $article;

        # if we have an event day then make that available to the class too
        if(isset($options['eventDay'])) {
            $this->eventDay = $options['eventDay'];
        }

        # grab the elements of the article we'll need
        $event = $article['event'];
        $listingData = $event['cinema'];

        # process the event show times and venues
        $venues = $this->getShowTimes($event);

        # if we didn't get any venues back then we can go no further
        if( ! $venues ) {
            return false;
        }

        # response array
        $response = [];

        $response['summary'] = [
            'isMovie' => true,
            'isMultiDate' => $this->isMultiDate,
            'certificate' => $listingData['certificate'],
            'director' => $listingData['director'],
            'duration' => $listingData['duration'],            
        ];  

        $response['venues'] = $this->sort($venues);

        return $response;
    }    

    /**
     * sort any venue show times into the API required format
     * 
     * @param  array $showTimes [a list of show times and their associated venue]
     * @return array - formatted list of show times and venues
     */
    public function getShowTimes($event = null)
    {
        $response = new stdClass();

        # get all of the show times for this particular event
        $showTimes = $event['show_time'];      

        //$showTimes = $this->sort($showTimes);

        # check to see whether this is a multi date performance
        $this->isMultiDate = $this->checkIsMultiDate($showTimes);

        # get the last performance in the list regardless of the date. This allows
        # for the from - range output in the front end
        $lastPerformance = $this->getLastPerformance($showTimes);

        # do some filtering
        if( ! is_null($this->eventDay) ) {
           $showTimes = $this->filterByEventDay($showTimes);
        }

        # it doesn't look like we go any showTimes back from the filterByEventDay call
        # this means we have no showTimes happening this EventDay
        if(count($showTimes) == 0) {
            return false;
        }

        # get the venue transformer
        $venueTransformer = App::make('Apiv1\Transformers\VenueTransformer');

        # init an empty array where can keep all the performances
        $performances = [];       

        # go through each of the show times and make them look pretty
        foreach($showTimes AS $performance)
        {
            $tmp = [
                # when is the performance taking place
                'startTime' => [
                    'epoch' => strtotime($performance['showtime']),
                    'readable' => $this->dateFormatter($performance['showtime']),
                    'day' => date('Y-m-d', strtotime($performance['showtime'])),
                    'time' => date('H:i', strtotime($performance['showtime']))
                ],
                # showRunEnd is the last date on which a multi-date performance will end
                'showRunEnd' => $lastPerformance,                
            ];     

            # attach the venue to the performance item
            $tmp['venue'] = $venueTransformer->transform($performance['venue']); 

            $performances[] = $tmp;     
        }

        # sort the performances by the date with the earliest start time first
        # by sorting them we always get the earliest performance in the range, its always kept 
        # because its the first item and we always know when the range ends because we set it above.
        # this is all very confusing!
        $performances = $this->sort($performances);

        $venues = [];
        $kept = [];

        # go through the performances and keep unique the performances at unique venues
        # we do this so we have a list of venues where the film is showing regardless of how
        # many times the show plays at a venue during it performance run
        foreach($performances AS $performance)
        {
            # if a performance at this venue has not been added to the list, then add it
            if(!in_array($performance['venue']['id'], $venues)) {
                $kept[] = $performance;
            }           

            # add this venue to the list of venues already seen and added to the performances array
            $venues[] = $performance['venue']['id'];
        }

        # and.... send it back
        return $kept;
    }

    /**
     * Go through the list of event show times and make sure they are on the given event day
     * 
     * @param  array $showTimes
     * @return array $kept [a list of items matching the given event day]
     */
    public function filterByEventDay($showTimes)
    {
        $kept = [];

        foreach($showTimes AS $showTime)
        {
            # turn the showtime into the same format as the given eventDay
            $date = date('Y-m-d', strtotime($showTime['showtime']));

            $today = date('Y-m-d');

            # grab the end date of the show so we can compare it to "todays" date
            $endDate = strtotime(date('Y-m-d', strtotime($showTime['showend'])));

            # if the event show time is the same as the eventDay then we want to keep it
            # this means get rid of anything thats not happening on the specified event day
            if($date == $this->eventDay) {
                $kept[] = $showTime;
            }
            
            // if(strtotime($this->eventDay) < $endDate) {
            //     $kept[] = $showTime;
            // }
        }

        return $kept;
    }

    /**
     * Format a timestamp to the class required format
     * 
     * @param  int $dateTime [unix timestamp]
     * @return array [formatted date / timestamp]
     */
    public function dateFormatter($dateTime)
    {
        return date('Y-m-d H:i', strtotime($dateTime));
    }

    public function checkIsMultiDate($showTimes)
    {
        $times = [];
        foreach($showTimes AS $showTime)        
        {
            $times[] = strtotime($showTime['showtime']);
        }

        if(count($times) > 1)
        {
            if(date('Y-m-d', $times[0]) != date('Y-m-d', $times[count($times)-1]))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * go through all of the showtimes regardless of eventDay and work out which 
     * is the very last performance
     * @param  array $showTimes
     * @return array [last show time]
     */
    public function getLastPerformance($showTimes)
    {
        $times = [];

        # go through each show time
        foreach($showTimes AS $showTime)        
        {
            # convert the show start time into an epoch and set it as the array key
            $times[strtotime($showTime['showtime'])] = $showTime;
        }

        # sort the array by the keys so they are in ascending order (giving us the first to last show times)
        ksort($times);

        # get the last item in the array. This should be the very last instance of this event
        $last = array_pop($times);

        # convert the showtime into the format needed and send it back.
        return [
            'epoch' => strtotime($last['showtime']),
            'readable' => $this->dateFormatter($last['showtime']),
            'day' => date('Y-m-d', strtotime($last['showtime'])),
            'time' => date('H:i', strtotime($last['showtime']))
        ];          
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
            # if the start date/time epoch doesn't exist then add it to the array
            if( ! array_key_exists($time['startTime']['epoch'], $sortedTimes) )
            {
                $sortedTimes[$time['startTime']['epoch']] = $time;    
            }
            # if we find that it does exist then there is a show at the same date/time.
            # we obviously want to keep this so we need to squeeze it into the array 
            # by incrementing the epoch by a second until we find a place for the performance.
            # We do this because there is a potential for several shows to be on at the same date
            # and time but at different venues
            else {
                # grab the start date/time epoch
                $key = $time['startTime']['epoch'];
                
                # we'll never have this many but try and squeeze the performance into the array
                # 1,000 times. Once its in then break out of the loop.
                for($i=1; $i < 1000; $i++)
                {
                    # for each iteration add 1 second to the epoch
                    $newKey = $key+$i;

                    # if the key doesn't exist then we can add the performance to the list
                    if(!array_key_exists($newKey, $sortedTimes))
                    {
                        $sortedTimes[$newKey] = $time;   
                        # and get out of this loop
                        break;
                    }
                }
            }
        }
        # sort the array keys into ascending numerical order. This gives us performances from
        # the earliest to the last
        ksort($sortedTimes);

        # and because we don't care about the array keys now they are sorted, reset them so
        # they go back to 0, 1, 2 etc.. then return our sorted times list
        return array_values($sortedTimes);
    }
}