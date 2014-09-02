<?php

Class ArticleController extends ApiController {

    /**
     * class constructor
     */
    public function __construct()
    {
        $this->responseMaker = App::make('ArticleResponseMaker');
    }

    /**
     * retrieve an article by its unique identifier, by-passing any channel or category assignment
     * 
     * @return ApiResponse
     */
    public function getArticle()
    {
        return $this->responseMaker->getStaticArticle(Input::only('article'));
    }

    /**
     * get an article for display on the desktop version of the site
     * 
     * @return array
     */
    public function getWebArticle()
    {
        if( ! Input::get('subchannel') || ! Input::get('category') || ! Input::get('article'))
        {
            return apiErrorResponse('insufficientArguments');
        }
        
        if( isApiResponse( $response = $this->responseMaker->make(Input::all(), $this)))
        {
            return $response;
        }
        
        return apiSuccessResponse( 'ok', $response );
    }

    /**
     * get an article for display on a mobile or tablet device
     * 
     * @return array
     */
    public function getAppArticle()
    {
        # if we don't have everything we need then say so
        if( ! Input::get('subchannel') || ! Input::get('category') || ! Input::get('article')) {
            return apiErrorResponse('insufficientArguments');
        }

        # if we get an API response object then something went wrong. 
        if( isApiResponse( $response = $this->responseMaker->make(Input::all()))) {
            return $response;
        }   

        # the data to send to the front end. used to populate the template
        $data = $response;

        # set the request headers
        $headers = [];

        # if authenticated then send through the access key
        if(userIsAuthenticated()) {
            $headers['accessKey'] = getAccessKey();
        }

        # make a call to the front end to retrieve the populated HTML template
        $result = App::make('ApiClient')->post('app/article', [ 
            # POST params
            'data' => $response, 
            'type' => getChannelType($response['channel']), 
        ], 
            # Header params
            $headers
        );

        $response['article'] = $this->responseMaker->getRequiredArticleData($response['article']);
        unset($response['related']);

        # remove hidden chars from the returned HTML as they break the markup on the device
        $response['html'] = str_replace("\n", '', $result['html']);

        # ... return it all to the calling app
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
