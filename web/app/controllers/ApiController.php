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
     * @var string
     */
    public $additionalInfo = null;

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

    public function setAdditionalInfo($info)
    {
        $this->additionalInfo = $info;
    }

    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
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
        $response = [
            'error' => [
                'message' => $message,
                'reason' => $this->getAdditionalInfo(),
                'statusCode' => $this->getStatusCode(),
                'method' => Request::getMethod(),
                'endpoint' => Request::path(),
                'time' => time(),
            ],
            'source' => [
                sourceClient()
            ]
        ];

        if( ! empty($response['error']['reason']) )
        {
            unset($response['error']['reason']);
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
