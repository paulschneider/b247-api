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

# Article

Route::resource('article', 'ArticleController');

# Category

Route::resource('category', 'CategoryController');

# Channels

Route::group(['prefix' => 'channel'], function(){
    Route::get('{channelId}/listing/{duration}/{timestamp}', 'ChannelController@getChannelListing');
    Route::get('{channelId}/{type}', 'ChannelController@show');
    Route::get('{channelId}', 'ChannelController@show');
});

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
