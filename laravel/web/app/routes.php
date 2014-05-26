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

# Registration

Route::get('register', VERSION.'\Controllers\RegisterController@index');
Route::post('register', VERSION.'\Controllers\RegisterController@store');
Route::controller('register', VERSION.'\Controllers\RegisterController');

# Channels

Route::get('channel/{id}', VERSION.'\Controllers\ChannelController@index');
Route::controller('channel', VERSION.'\Controllers\ChannelController');

# Article

Route::get('article/{id}', VERSION.'\Controllers\ArticleController@index');
Route::get('article', VERSION.'\Controllers\ArticleController@create');
Route::post('article', VERSION.'\Controllers\ArticleController@store');
Route::controller('article', VERSION.'\Controllers\ArticleController');

# Homepage

Route::get('/', VERSION.'\Controllers\HomeController@index');
Route::controller('/', VERSION.'\Controllers\HomeController');
