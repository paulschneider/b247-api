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

Event::listen('illuminate.query', function($query, $params, $time, $conn)
{
    //dd(array($query, $params, $time, $conn));
});

# Article

Route::resource('article', VERSION.'\Controllers\ArticleController');

# Category

Route::resource('category', VERSION.'\Controllers\CategoryController');

# Channels

Route::resource('channel', VERSION.'\Controllers\ChannelController');

# Registration

Route::resource('register', VERSION.'\Controllers\RegisterController');

# Homepage

Route::resource('/', VERSION.'\Controllers\HomeController');
