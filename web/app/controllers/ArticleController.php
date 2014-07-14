<?php

Class ArticleController extends ApiController {

    public function __construct()
    {
        $this->responseMaker = App::make('ArticleResponseMaker');
    }

    public function getWebArticle()
    {
        if( ! Input::get('channel') || ! Input::get('category') || ! Input::get('article'))
        {
            return apiErrorResponse('insufficientArguments');
        }
        
        if( isApiResponse( $response = $this->responseMaker->make(Input::all(), $this)))
        {
            return $response;
        }
        
        return apiSuccessResponse( 'contentLocated', $response );
    }

    public function getAppArticle()
    {
        if( ! Input::get('channel') || ! Input::get('category') || ! Input::get('article'))
        {
            return apiErrorResponse('insufficientArguments');
        }

        $data = ApiClient::get('app/article', [ 'channel' => Input::get('channel'), 'category' => Input::get('category'), 'article' => Input::get('article') ]);

        sd($data);
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
