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
        return $this->setStatusCode(422)->respondWithError($message);
    }

    /**
     * respond that the HTTP call being made is not supported
     *
     * @return Response
     */
    public function respondNotSupported($message = "Not supported")
    {
        return $this->setStatusCode(501)->respondWithError($message);
    }

    /**
     * respond that a record wa successfully created
     *
     * @return Response
     */
    public function respondCreated($message = "Created", $data = null)
    {
        return $this->setStatusCode(201)->respondWithSuccess($message, $data);
    }

    /**
     * respond that the call was successful and return the data to the client
     *
     * @return Response
     */
    public function respondFound($message = "Found", $data = null)
    {
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
                'message' => $message
                ,'statusCode' => $this->getStatusCode()
                ,'endpoint' => Request::path()
                ,'time' => time()
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
                ,'endpoint' => Request::path()
                ,'time' => time()
                ,'data' => $data
            ]
        ]);
    }
}
