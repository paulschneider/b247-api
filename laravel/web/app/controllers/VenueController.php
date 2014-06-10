<?php

use Version1\Venues\Venue;
use Version1\Venues\VenueRepository;

Class VenueController extends ApiController {

    /**
    *
    * @var Version1\Venues\VenueRepository
    */
    protected $venueRepository;

    public function __construct(VenueRepository $venueRepository)
    {
        $this->venueRepository = $venueRepository;
    }

    public function index()
    {
        $venues = $this->venueRepository->getVenues();

        return View::make('venues.show', compact('venues'));
    }

    public function create()
    {
        $venue = new Venue();

        return View::make('venues.create', compact('venue'));
    }

    public function show($identifier = null)
    {
        //
    }

    public function edit($id = null)
    {
        $venue = $this->venueRepository->getVenue($id);

        return View::make('venues.create', compact('venue'));
    }

    /**
     * Store a newly created / recently updated resource
     *
     * @return Response
     */
    public function store()
    {
        if( $venue = $this->venueRepository->store(Input::all()) )
        {
            return Redirect::to('venue');
        }
        else
        {
            return $this->respondNotValid($venue->errors);
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
