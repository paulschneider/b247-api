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

Route::get('article/list', VERSION.'\Controllers\ArticleController@show');
Route::get('article/edit/{id}', VERSION.'\Controllers\ArticleController@create');
Route::get('article/{id}', VERSION.'\Controllers\ArticleController@index');
Route::get('article', VERSION.'\Controllers\ArticleController@create');
Route::post('article', VERSION.'\Controllers\ArticleController@store');
Route::controller('article', VERSION.'\Controllers\ArticleController');

# Category
Route::get('category/list', VERSION.'\Controllers\CategoryController@show');
Route::get('category/edit/{id}', VERSION.'\Controllers\CategoryController@create');
Route::get('category/create', VERSION.'\Controllers\CategoryController@create');
Route::post('category', VERSION.'\Controllers\CategoryController@store');

# Channels

Route::get('channel/list', VERSION.'\Controllers\ChannelController@show');
Route::get('channel/create', VERSION.'\Controllers\ChannelController@create');
Route::get('channel/edit/{id}', VERSION.'\Controllers\ChannelController@create');
Route::get('channel/{id}', VERSION.'\Controllers\ChannelController@index');
Route::post('channel', VERSION.'\Controllers\ChannelController@store');
Route::controller('channel', VERSION.'\Controllers\ChannelController');

# Homepage

Route::get('/', VERSION.'\Controllers\HomeController@index');
Route::controller('/', VERSION.'\Controllers\HomeController');

# Registration

Route::get('register', VERSION.'\Controllers\RegisterController@index');
Route::post('register', VERSION.'\Controllers\RegisterController@store');
Route::controller('register', VERSION.'\Controllers\RegisterController');
