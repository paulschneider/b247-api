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
Route::group(['prefix' => 'category'], function(){
	Route::get('/', 'CategoryController@index');
});

# Channels

Route::group(['prefix' => 'channel'], function(){
	Route::get('/', 'ChannelController@index');
	Route::get('{channelId}/edit', 'ChannelController@edit');
	Route::post('store', 'ChannelController@store');
    Route::get('{channelId}/listing/{duration}', 'ChannelController@getChannelListing');
    Route::get('{channelId}/{type}', 'ChannelController@show');
    Route::get('{channelId}', 'ChannelController@show');
});

# Events

Route::resource('event', 'EventController');

# Registration

Route::resource('register', 'RegisterController');

# Sponsor

Route::resource('sponsor', 'SponsorController');

# Venue

Route::resource('venue', 'VenueController');

# Homepage

Route::get('/', 'HomeController@index');
