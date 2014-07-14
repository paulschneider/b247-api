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
    public function respondWithError($message)
    {   
        return $this->respond([
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
}
