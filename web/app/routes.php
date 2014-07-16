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

//if( isMobile() )

if( Input::get('dataOnly') )
{
    Route::get('articles', 'ArticleController@getWebArticle');   
}
else
{
    Route::get('articles', 'ArticleController@getAppArticle');
}

# Application Navigation

Route::get('app/nav', 'AppNavigationController@index');

# Category

Route::group(['prefix' => 'category'], function(){
    Route::get('/', 'CategoryController@index');

	// route aliases as required by mobile apps (or at least requested)
	Route::get('{categoryId}/{listing}/articles', 'CategoryController@getCategoryArticles'); // these
    Route::get('{categoryId}/{article}/articles', 'CategoryController@getCategoryArticles'); // are
    Route::get('{categoryId}/{directory}/articles', 'CategoryController@getCategoryArticles'); // aliases
    Route::get('{categoryId}/{promotion}/articles', 'CategoryController@getCategoryArticles'); // for

    Route::get('{categoryId}/articles', 'CategoryController@getCategoryArticles'); // this
});

# Channels

Route::group(['prefix' => 'channel'], function(){
	Route::get('/', 'ChannelController@index');
	Route::get('{channel}/edit', 'ChannelController@edit');
	Route::post('store', 'ChannelController@store');

    Route::get('{channel}/{listing}', 'ChannelController@getSubChannel'); // these
    Route::get('{channel}/{article}', 'ChannelController@getSubChannel'); // are
    Route::get('{channel}/{directory}', 'ChannelController@getSubChannel'); // aliases
    Route::get('{channel}/{promotion}', 'ChannelController@getSubChannel'); // for

    Route::get('{channel}/articles', 'ChannelController@getSubChannel'); // this

    Route::get('{channel}', 'ChannelController@getChannel');
});

Route::post('login', 'SessionsController@login');

# Registration

Route::post('register', 'RegisterController@createSubscriber');

# Search

Route::get('search', 'SearchController@search');

# User

Route::post('user/password', 'UserController@changeUserPassword');
    
# Homepage

Route::get('/', 'HomeController@index');
