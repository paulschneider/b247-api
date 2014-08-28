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
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        $this->article = $article;

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

        $this->venues = $venues;
        $response = [];

        # grab the main event so we can get some info out of it for the overview response
        $primary = $venues->primary;

        $response['summary'] = [
            'isMovie' => true,
            'isMultiDate' => $this->isMultiDate,
            'certificate' => $listingData['certificate'],
            'director' => $listingData['director'],
            'duration' => $listingData['duration'],
            'show' => $primary,
            'price' => $primary['price']
        ];  

        # grab the list of possible alternative venues
        $response['alternativeVenues'] = $venues->alternatives;

        return $response;
    }

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
     * sort any venue show times into the API required format
     * 
     * @param  array $showTimes [a list of show times and their associated venue]
     * @return array - formatted list of show times and venues
     */
    public function getShowTimes($event = null)
    {
        $response = new stdClass();

        $showTimes = $event['show_time'];

        $this->isMultiDate = $this->checkIsMultiDate($showTimes);

        $lastPerformance = $this->getLastPerformance($showTimes);

        # do some filtering
        if( !is_null($this->eventDay) ) {
           $showTimes = $this->filterByEventDay($showTimes);
        }

        # it doesn't look like we go any showTimes back from the filterByEventDay call
        # this means we have no showTimes happening this EventDay
        if(count($showTimes) == 0) {
            return false;
        }

        # get the venue transformer
        $venueTransformer = App::make('Apiv1\Transformers\VenueTransformer');

        $alternatives = [];
        $primary = [];

        # the event attached to the article is the primary event. everything else is supplemental 
        # information we want to show. We need the primary event ID to work out which it is from the showtimes
        # list
        $primaryEventVenueId = $event['venue_id'];

        # go through each of the show times and make them look pretty
        foreach($showTimes AS $performance)
        {
            $show = [
                # when is the performance taking place
                'startTime' => [
                    'epoch' => strtotime($performance['showtime']),
                    'readable' => $this->dateFormatter($performance['showtime']),
                    'day' => date('Y-m-d', strtotime($performance['showtime'])),
                    'time' => date('H:i', strtotime($performance['showtime']))
                ],
                'price' => number_format( $performance['price'], 2 ),
                # showRunEnd is the last date on which a multi-date performance will end
                'showRunEnd' => $lastPerformance,
                # where is the performance taking place
                'venue' => $venueTransformer->transform($performance['venue'])
            ];

            # if its not the primary event ID then its an alternative venue
            if($performance['venue_id'] != $primaryEventVenueId) {
                
                # the value of showRunEnd is for the primary venue only. 
                # Not for the alternatives, so get rid of it.
                unset($show['showRunEnd']);

                $alternatives[$performance['venue_id']] = $show;
            }
            # this is the main event which we need to grab separately
            else {
                # we already have this info from the main event object so get shot of it
                unset($show['venue']);

                # this is the one we want
                $primary = $show;
            }           
        }

        $response->primary = $primary;
        $response->alternatives = array_values($alternatives);      

        # and.... send it back
        return $response;
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
            if($date == $this->eventDay) {
                $kept[] = $showTime;
            }
            
            if(strtotime($this->eventDay) < $endDate) {
                $kept[] = $showTime;
            }
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