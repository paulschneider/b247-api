<?php

namespace Version1\Controllers;

use Controller;
use Request;
use Response;

class BaseController extends Controller
{
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    public static function respond($data, $responseCode)
    {
        $response = Response::make(json_encode($data), $responseCode);

        $response->header('Content-Type', 'application/json');

        return $response;
    }

}
