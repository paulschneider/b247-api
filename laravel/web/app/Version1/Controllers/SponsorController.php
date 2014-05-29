<?php namespace Version1\Controllers;

use View;
use Input;
use Redirect;

class SponsorController extends ApiController {

	/**
	 * Display a listing of sponsors.
	 *
	 * @return Response
	 */
	public function index()
	{
		$sponsors = \Version1\Models\Sponsor::getAscendingList();

		return View::make('sponsor.show', [ 'sponsors' => $sponsors ]);
	}

	/**
	 * Show the form for creating a new sponsor.
	 *
	 * @return Response
	 */
	public function create()
	{
		$sponsor = new \Version1\Models\Sponsor();

		return View::make('sponsor.create', [ 'sponsor' => $sponsor ]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if( ! $sponsor = \Version1\Models\Sponsor::storeSponsor(Input::all()) )
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
		$sponsor = \Version1\Models\Sponsor::findOrFail($id);

		return View::make('sponsor.create', [ 'sponsor' => $sponsor ]);
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
