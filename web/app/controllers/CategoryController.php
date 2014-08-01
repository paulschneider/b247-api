<?php

Class CategoryController extends ApiController {

    var $responseMaker;

    public function getCategoryArticles($category = null)
    {   
        if( ! Input::get('subChannel') )
        {
            return apiErrorResponse('insufficientArguments');
        }           

        if(isApiResponse( $response = App::make('CategoryResponseMaker')->make($category, Input::get('subChannel')) )) 
        {
            return $response;
        }

        return apiSuccessResponse( 'ok', $response );
    }
}
