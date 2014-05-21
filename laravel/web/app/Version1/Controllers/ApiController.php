<?php namespace Version1\Controllers;

use Controller;
use Request;
use Response;

class ApiController Extends BaseController {

    /**
     * @var int
     */
    protected $statusCode = 200;

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
     * request a 404 message be returned to the API client
     *
     * @return Response
     */
    public function respondNotFound($message = "Not found")
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * respond that the supplied details were invalid
     *
     * @return Response
     */
    public function respondNotValid($message = "Invalid")
    {
        return $this->setStatusCode(406)->respondWithError($message);
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
                'message' => $message
                ,'statusCode' => $this->getStatusCode()
                ,'endpoint' => Request::path()
                ,'time' => time()
            ]
        ]);
    }
}
