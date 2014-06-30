<?php

function clog($message)
{
    return Clockwork::info($message);
}

function start($name, $description)
{
    return Clockwork::startEvent($name, $description);
}

function stop($name)
{
    return Clockwork::endEvent($name);
}

/*
|--------------------------------------------------------------------------
| Database filter
|--------------------------------------------------------------------------
|
|
*/
App::error(function(PDOException $exception)
{
    Log::error("Error connecting to database: ".$exception->getMessage());
    //return "Error connecting to database";
});
