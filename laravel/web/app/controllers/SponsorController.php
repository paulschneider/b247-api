<?php

use Version1\Sponsors\SponsorRepository;
use Version1\Sponsors\Sponsor;
use Version1\Models\DisplayStyle;

Class SponsorController extends ApiController {

    /**
    *
    * @var Version1\Sponsor\SponsorRepository
    */
    protected $sponsorRepository;

    public function __construct(SponsorRepository $sponsorRepository)
    {
        $this->sponsorRepository = $sponsorRepository;
    }

	/**
	 * Display a listing of sponsors.
	 *
	 * @return Response
	 */
	public function index()
	{
		$sponsors = $this->sponsorRepository->getAscendingList();

		return View::make('sponsor.show', compact('sponsors'));
	}

	/**
	 * Show the form for creating a new sponsor.
	 *
	 * @return Response
	 */
	public function create()
	{
		$sponsor = new Sponsor();
        $displayStyles = DisplayStyle::getSimpleDisplayTypes();

		return View::make('sponsor.create', compact('sponsor', 'displayTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if( ! $sponsor = $this->sponsorRepository->storeSponsor(Input::all()) )
		{
			return $this->respondNotValid($sponsor->errors);
		}
		else
		{
			return Redirect::to('sponsor');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified sponsor.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sponsor = $this->sponsorRepository->getSponsorById($id);
        $displayStyles = DisplayStyle::getSimpleDisplayStyles();

		return View::make('sponsor.create', compact('sponsor', 'displayStyles'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return ApiController::respondNotAllowed();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return ApiController::respondNotAllowed();
	}

}
