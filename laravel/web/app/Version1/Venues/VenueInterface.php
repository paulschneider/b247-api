<?php namespace Version1\Venues;

Interface VenueInterface {

    public function getVenueList();

    public function getVenue($id);    

    public function getVenues();

    public function store($form);
}
