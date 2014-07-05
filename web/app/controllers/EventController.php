<?php

use Version1\Events\Event;

Class EventController extends ApiController {

    public function __construct()
    {
        parent::__construct();       
    }

    /**
     * show a list of existing resources
     *
     * @return Response
     */
    public function index()
    {
        $events = $this->eventRepository->getEvents();

        return View::make('events.show', compact('events'));
    }

    /**
     * create a new resource
     *
     * @return Response
     */
    public function create()
    {
        $event = new Event();

        $venues = $this->venueRepository->getVenueList();

        return View::make('events.create', compact('event', 'venues'));
    }

    /**
     * return the details of an existing resource
     *
     * @return Response
     */
    public function show($identifier = null)
    {
        //
    }

    /**
     * edit an existing resource
     *
     * @return Response
     */
    public function edit($id = null)
    {
        if( ! is_numeric($id) )
        {
            return $this->respondNotValid('Invalid articled identifier supplied.');
        }

        $event = $this->eventRepository->getEvent($id);
        $venues = $this->venueRepository->getVenueList();

        return View::make('events.create', compact('event', 'venues'));
    }

    /**
     * Store a newly created / recently updated resource
     *
     * @return Response
     */
    public function store()
    {
        if( $event = $this->eventRepository->store(Input::all()) )
        {
            return Redirect::to('event');
        }
        else
        {
            return $this->respondNotValid($event->errors);
        }
    }

    /**
    * action on an UPDATE call to the resource
    *
    * @return ApiController Response
    */
    public function update()
    {
        return ApiController::respondNotAllowed();
    }

    /**
    * action on an UPDATE call to the resource
    *
    * @return ApiController Response
    */
    public function destroy()
    {
        return ApiController::respondNotAllowed();
    }
}
