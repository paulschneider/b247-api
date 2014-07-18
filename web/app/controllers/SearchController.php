<?php

Class SearchController extends ApiController {

	public function search()
	{
		if( ! Input::get('q') )
		{
			return apiErrorResponse('insufficientArguments');
		}

		if( isApiResponse( $response = App::make('SearchResponseMaker')->make(Input::get('q'))))
        {
            return $response;
        }

        // return it all to the calling app
        return apiSuccessResponse( 'ok', $response );
	}
}