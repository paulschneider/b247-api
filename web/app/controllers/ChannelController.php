<?php

Class ChannelController extends ApiController {
    /**
    * get the details of a channel
    *
    * @return Response
    */
    public function getChannel($identifier)
    {
        return App::make('ChannelResponseMaker')->make( $identifier );
    }

    /**
    * get the details of a sub-channel
    *
    * @return *
    */
    public function getSubChannel( $identifier, $type)
    {   
        if( is_null($identifier) || is_null($type) )
        {
            return apiErrorResponse('insufficientArguments');
        }
 
        if( isApiResponse( $response = App::make('SubChannelResponseMaker')->make( $identifier ) ))
        {
            return $response;
        }        

        return apiSuccessResponse( 'ok', $response );
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
