<?php

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
