<?php

Class ChannelController extends ApiController {
    /**
    * get the details of a channel
    *
    * @return Response
    */
    public function getChannel($identifier)
    {
        if( is_null($identifier) )
        {
            return apiErrorResponse('insufficientArguments');
        }

        if( isApiResponse( $response = App::make('ChannelResponseMaker')->make( $identifier ) ))
        {
            return $response;
        } 

        return apiSuccessResponse( 'contentLocated', $response );
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

        return apiSuccessResponse( 'contentLocated', $response );
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
