<?php namespace Apiv1\Transformers;

use App;
use stdClass;

Class CinemaListingTransformer extends Transformer {

    private $eventDay = null;

    /**
     * Transform a result set into the API required format
     *
     * @param user
     * @return array
     */
    public function transform( $article, $options = [] )
    {
        if(isset($options['eventDay'])) {
            $this->eventDay = $options['eventDay'];
        }

        # grab the elements of the article we'll need
        $event = $article['event'];
        $listingData = $event['cinema'];

        # process the event show times and venues
        $venues = $this->getShowTimes($event);

        $response = [];

        # grab the main event so we can get some info out of it for the overview response
        $primary = $venues->primary;

        $response['summary'] = [
            'isMovie' => true,
            'isMultiDate' => $this->checkIsMultiDate($primary),
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
    public function getShowTimes($event)
    {
        $response = new stdClass();

        $showTimes = $event['show_time'];

        # do some filtering
        if( !is_null($this->eventDay) ) {
            $showTimes = $this->filterByEventDay($showTimes);
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
            # if we got to here then these performances are happening "today". If its a range of
            # performances the show start is not necessarily the day of the performance, just the first in a
            # list of performances. If this is the case we need to change the show_date to be "today" otherwise it will
            # not be added to the list of article events happening "today"

            if($this->eventDay != date('Y-m-d', strtotime($performance['showtime'])))
            {                  
                # whats the original show time
                $performanceTime = date('H:i', strtotime($performance['showtime']));

                # whats today
                $todaysPerformance = date($this->eventDay . ' ' . $performanceTime);

                # this is todays performance at the range's specified performance time, just its for today
                $performance['showtime'] = $todaysPerformance;
            }

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
                'showRunEnd' => [
                    'epoch' => strtotime($performance['showend']),
                    'readable' => $this->dateFormatter($performance['showend']),
                    'day' => date('Y-m-d', strtotime($performance['showend'])),
                    'time' => date('H:i', strtotime($performance['showend'])),
                ],
                # where is the performance taking place
                'venue' => $venueTransformer->transform($performance['venue'])
            ];

            # if its not the primary event ID then its an alternative venue
            if($performance['venue_id'] != $primaryEventVenueId) {
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
            else if(strtotime($this->eventDay) < $endDate) {
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

    public function checkIsMultiDate($event)
    {
        if(strtotime($event['startTime']['day']) < strtotime($event['showRunEnd']['day']) )
        {
            return true;
        }

        return false;
    }
}