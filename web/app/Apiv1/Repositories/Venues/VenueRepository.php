<?php namespace use Apiv1\Repositories\Venues;

use Apiv1\Repositories\Venues\VenueInterface;
use Apiv1\Repositories\Venues\Venue;
use Apiv1\Repositories\Models\BaseModel;

Class VenueRepository extends BaseModel {

    public function getVenueList()
    {
        return Venue::active()->alive()->lists('name', 'id');
    }

    public function getVenue($venueId)
    {
        return Venue::findOrFail($venueId);
    }

    public function getVenues()
    {
        return Venue::alive()->get();
    }
}
