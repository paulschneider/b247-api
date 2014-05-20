<?php

class HomeController extends \BaseController
{
	public function getIndex()
	{
		$method = Request::method();

		// get the parent of a sub-channel
		//$parent = SubChannel::find($id)->parent;

		$channels = Channel::with('subChannel.channelCategory.category')->get()->toArray();

		$result = new stdClass();
		$result->channels = clean($channels);

		if( Request::header('accessKey') )
		{
			require(storage_path() . '/test-data/auth.php');
		}
		else
		{
			require(storage_path() . '/test-data/no-auth.php');
		}

		$response = Response::make(json_encode($result), 200);

		$response->header('Content-Type', 'application/json');

		Log::debug(DB::getQueryLog());

		return $response;
	}
}
