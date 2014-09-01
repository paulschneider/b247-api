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

        $response['venues'] = $venues;

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

        $venues = [];

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

            # where is the performance taking place
            $venue =  $venueTransformer->transform($performance['venue']);

            # attach the venue to the performance item
            $tmp['venue'] = $venue; 

            # if a performance at this venue has not been added to the list, then add it
            if(!in_array($venue['id'], $venues)) {
                $performances[] = $tmp;
            }           

            # add this venue to the list of venues already seen and added to the performances array
            $venues[] = $venue['id'];
        }

        # and.... send it back
        return $performances;
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
        asort($times);

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
}