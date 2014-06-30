<?php namespace Version1\Events;

Interface EventInterface {

    public function getEventListing($limit);

    public function store($form);

    public function getEvents();

    public function getEvent($eventId);
}
