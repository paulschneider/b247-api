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
     * respond that a record was successfully created
     *
     * @return Response
     */
    public function respondCreated($message = null, $data = null)
    {
        $this->setMessage($message, Lang::get('api.defaultRespondCreated'));
        return $this->setStatusCode(201)->respondWithSuccess($message, $data);
    }

    /**
     * request a 404 message be returned to the API client
     *
     * @return Response
     */
    public function respondNotFound($message = null)
    {
        $this->setMessage($message, Lang::get('api.defaultRespondNotFound'));
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * respond that the that not enough parameters were provided
     *
     * @return Response
     */
    public function respondWithInsufficientParameters($message = null)
    {
        $this->setMessage($message, Lang::get('api.defaultRespondInsufficientParameters'));
        return $this->setStatusCode(412)->respondWithError($message);
    }

    /**
     * respond that the supplied details were invalid
     *
     * @return Response
     */
    public function respondNotValid($message = null)
    {
        $this->setMessage($message, Lang::get('api.defaultRespondNotValid'));
        return $this->setStatusCode(422)->respondWithError($message);
    }

    /**
     * respond that the HTTP call being made is not supported
     *
     * @return Response
     */
    public function respondNotSupported($message = null)
    {
        $this->setMessage($message, Lang::get('api.defaultRespondNotSupported'));
        return $this->setStatusCode(501)->respondWithError($message);
    }

    ############################################################################ Responders

    /**
     * respond that the call was successful and return the data to the client
     *
     * @return Response
     */
    public function respondFound($message = null, $data = null)
    {
        $this->setMessage($message, Lang::get('api.defaultRespondFound'));
        return $this->respondWithSuccess($message, $data);
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
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $this->getMessage()
                ,'statusCode' => $this->getStatusCode()
                ,'method' => Request::getMethod()
                ,'endpoint' => Request::path()
                ,'time' => time()
            ],
            'source' => [
                sourceClient()
            ]
        ]);
    }

    /**
     * return an error to the API client
     *
     * @return Response
     */
    public function respondWithSuccess($message, $data = null)
    {
        return $this->respond([
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
    }

    /**
     * respond that the request was successful but no results were found
     *
     * @return Response
     */
    public function respondNoDataFound($message = null, $statusCode = 404)
    {
        $this->setStatusCode( $statusCode );
        $this->setMessage($message, Lang::get('api.defaultRespondNoDataFound'));

        return $this->respond([
            'error' => [
                'message' => $this->getMessage()
                ,'statusCode' => $statusCode
                ,'method' => Request::getMethod()
                ,'endpoint' => Request::path()
                ,'time' => time()
            ],
            'source' => [
                sourceClient()
            ]
        ]);
    }

    /**
     * respond with a generic bad request message - this is a coverall for the unexpected
     *
     * @return Response
     */
    public function respondBadRequest($message = null, $statusCode=400)
    {
        $this->setStatusCode( $statusCode );
        $this->setMessage($message, Lang::get('api.defaultRespondNoDataFound'));

        return $this->respond([
            'error' => [
                'message' => $this->getMessage()
                ,'statusCode' => $statusCode
                ,'method' => Request::getMethod()
                ,'endpoint' => Request::path()
                ,'time' => time()
            ],
            'source' => [
                sourceClient()
            ]
        ]);
    }

    /**
     * respond with a generic not allowed message for all non-supported HTTP requests
     *
     * @return Response
     */
    public function respondNotAllowed($message = "", $statusCode = 501)
    {
        $this->setStatusCode( $statusCode );
         $this->setMessage($message, Lang::get('api.defaultRespondNotAllowed'));

        return $this->respond([
            'error' => [
                'message' => $this->getMessage()
                ,'statusCode' => $statusCode
                ,'method' => Request::getMethod()
                ,'endpoint' => Request::path()
                ,'time' => time()
            ],
            'source' => [
                sourceClient()
            ]
        ]);
    }
}
