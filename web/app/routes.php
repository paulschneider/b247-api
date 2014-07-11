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

	// route aliases as required by mobile apps (or at least requested)
	Route::get('{categoryId}/{listing}/articles', 'CategoryController@getCategoryArticles');
    Route::get('{categoryId}/{article}/articles', 'CategoryController@getCategoryArticles');
    Route::get('{categoryId}/{directory}/articles', 'CategoryController@getCategoryArticles');
    Route::get('{categoryId}/{promotion}/articles', 'CategoryController@getCategoryArticles');

    Route::get('{categoryId}/articles', 'CategoryController@getCategoryArticles');
});

# Channels

Route::group(['prefix' => 'channel'], function(){
	Route::get('/', 'ChannelController@index');
	Route::get('{channelId}/edit', 'ChannelController@edit');
	Route::post('store', 'ChannelController@store');
    Route::get('{channelId}/{listing}', 'ChannelController@getSubChannel');
    Route::get('{channelId}/{article}', 'ChannelController@getSubChannel');
    Route::get('{channelId}/{directory}', 'ChannelController@getSubChannel');
    Route::get('{channelId}/{promotion}', 'ChannelController@getSubChannel');
    Route::get('{channelId}', 'ChannelController@getChannel');
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
