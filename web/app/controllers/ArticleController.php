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
        
        if( isApiResponse( $response = $this->responseMaker->make(Input::all(), $this)))
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
        $result = App::make('ApiClient')->post('app/article', [ 'data' => $response, 'type' => getChannelType($response['channel']) ]);

        $response['article'] = $this->responseMaker->getRequiredArticleData($response['article']);
        unset($response['related']);

        // remove all hidden chars from the returned HTML as they break the markup on the device
        $response['html'] = str_replace("\n", '', $result['html']);

        // return it all to the calling app
        return apiSuccessResponse( 'ok', $response );
    }

    /**
     * Redeem an article promotional code
     * 
     * @return mixed $response
     */
    public function redeemArticlePromotion()
    {
        return App::make('Apiv1\Factory\ArticlePromotionRedemptionResponseMaker')->redeem(Input::all());
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
