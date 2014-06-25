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

Route::get('channel/listing/{channelId}/{duration}/{timestamp}', 'ChannelController@getChannelListing');
Route::get('channel/{article}/{channelId}', 'ChannelController@getChannelArticles');
Route::get('channel/{promotion}/{channelId}', 'ChannelController@getChannelArticles');
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
