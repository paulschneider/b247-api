<?php

class ApiController Extends BaseController {

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var string
     */
    public $message;

    /**
     * get the Api response code for this request
     *
     * @return statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * set the Api response code for this request
     *
     * @return null
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * get the message for the current request
     *
     * @return message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * set the message for the current request
     *
     * @return null
     */
    public function setMessage($overrideMessage, $defaultMessage)
    {
        if( ! is_null($overrideMessage) )
        {
            $this->message = $overrideMessage;
        }
        else
        {
            $this->message = $defaultMessage;
        }
    }

    /**
     * send the response back to the API client
     *
     * @return Response
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * return an error to the API client
     *
     * @return Response
     */
    public function respondWithError($message, $data = [])
    {   
        $response = [
            'error' => [
                'message' => $message,
                'statusCode' => $this->getStatusCode(),
                'method' => Request::getMethod(),
                'endpoint' => Request::path(),
                'time' => time(),
            ],
            'source' => [
                sourceClient()
            ]
        ];

        if( !empty($data) )
        {
            $response['error']['data'] = $data;
        }

        # if we're in development mode and there is a debug parameter in the address bar
        # we will show a debug page instead of the API response
        if(Input::get('debug') && App::environment('development'))
        {
            return View::make('debug.show');
        }

        return $this->respond($response);
    }

    /**
     * return an error to the API client
     *
     * @return Response
     */
    public function respondWithSuccess($message, $data = null)
    {
        $response = $this->respond([
            'success' => [
                'message' => $message
                ,'statusCode' => $this->getStatusCode()
                ,'method' => Request::getMethod()
                ,'endpoint' => Request::path()
                ,'time' => time()
                ,'data' => $data
            ],
            'source' => [
                sourceClient()
            ]
        ]);

        # if we're in development mode and there is a debug parameter in the address bar
        # we will show a debug page instead of the API response
        if(Input::get('debug') && App::environment('development'))
        {
            return View::make('debug.show');
        }

        return $response;
    }
}
