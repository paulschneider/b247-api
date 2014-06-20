<?php

class BaseController Extends Controller {

    public function __construct()
    {
        $this->beforeFilter(function()
        {
            Event::fire('clockwork.controller.start');
        });

        $this->afterFilter(function()
        {
            Event::fire('clockwork.controller.end');
        });
    }
}
