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
    //sd(array($query, $params, $time, $conn));
});

# Article

Route::resource('article', 'ArticleController');

# Category

Route::resource('category', 'CategoryController');

# Channels

Route::resource('channel', 'ChannelController');

# Events

Route::resource('event', 'EventController');

# Registration

Route::resource('register', 'RegisterController');

# Sponsor

Route::resource('sponsor', 'SponsorController');

# Venue

Route::resource('venue', 'VenueController');

# Homepage

Route::resource('/', 'HomeController');
