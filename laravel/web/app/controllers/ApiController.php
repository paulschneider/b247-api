<?php

class ApiController Extends Controller {

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
     * respond that a record was successfully created
     *
     * @return Response
     */
    public function respondCreated($message = "Created", $data = null)
    {
        return $this->setStatusCode(201)->respondWithSuccess($message, $data);
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
     * respond that the that not enough parameters were provided
     *
     * @return Response
     */
    public function respondWithInsufficientParameters($message = "Not enough arguments")
    {
        return $this->setStatusCode(412)->respondWithError($message);
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

    ############################################################################ Responders

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
    public static function respondNoDataFound($message = "Call successful. Nothing to return.", $statusCode = 204)
    {
        return Response::json([
            'error' => [
                'message' => $message
                ,'statusCode' => $statusCode
                ,'method' => Request::getMethod()
                ,'endpoint' => Request::path()
                ,'time' => time()
            ],
            'source' => [
                sourceClient()
            ]
        ], $statusCode);
    }

    /**
     * respond with a generic bad request message - this is a coverall for the unexpected
     *
     * @return Response
     */
    public static function respondBadRequest($message = "Bad request. Please check the documention for the usage of this API endpoint.", $statusCode=400)
    {
        return Response::json([
            'error' => [
                'message' => $message
                ,'statusCode' => $statusCode
                ,'method' => Request::getMethod()
                ,'endpoint' => Request::path()
                ,'time' => time()
            ],
            'source' => [
                sourceClient()
            ]
        ], $statusCode);
    }

    /**
     * respond with a generic not allowed message for all non-supported HTTP requests
     *
     * @return Response
     */
    public static function respondNotAllowed($message = 'Endpoint does not support method.', $statusCode = 501)
    {
        return Response::json([
            'error' => [
                'message' => $message
                ,'statusCode' => $statusCode
                ,'method' => Request::getMethod()
                ,'endpoint' => Request::path()
                ,'time' => time()
            ],
            'source' => [
                sourceClient()
            ]
        ], $statusCode);
    }
}
