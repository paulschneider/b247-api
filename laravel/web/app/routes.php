<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Event::listen('illuminate.query', function($query){
//      var_dump($query);
// });

define('VERSION', Config::get('app.version'));

# Registration
Route::get('register', VERSION.'\Controllers\RegisterController@create');
Route::post('register', VERSION.'\Controllers\RegisterController@store');

# Channels
Route::get('channel/{id}', VERSION.'\Controllers\ChannelController@index');
Route::controller('channel', VERSION.'\Controllers\ChannelController');

# Homepage
Route::get('/', VERSION.'\Controllers\HomeController@index');
