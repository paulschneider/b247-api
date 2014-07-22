<?php

Class ArticleController extends ApiController {

    public function __construct()
    {
        $this->responseMaker = App::make('ArticleResponseMaker');
    }

    public function getWebArticle()
    {
        if( ! Input::get('subchannel') || ! Input::get('category') || ! Input::get('article'))
        {
            return apiErrorResponse('insufficientArguments');
        }
        
        if( isApiResponse( $response = $this->responseMaker->make(Input::all())))
        {
            return $response;
        }
        
        return apiSuccessResponse( 'ok', $response );
    }

    public function getAppArticle()
    {
        if( ! Input::get('subchannel') || ! Input::get('category') || ! Input::get('article'))
        {
            return apiErrorResponse('insufficientArguments');
        }

        if( isApiResponse( $response = $this->responseMaker->make(Input::all())))
        {
            return $response;
        }   
 
        // make a call to the front end to retrieve the populated HTML template
        $data = ApiClient::post('app/article', [ 'data' => $response['article'], 'type' => getChannelType($response['channel']) ]);

        unset($response['article']);

        $response['article'] = $data['html'];

        // return it all to the calling app
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
