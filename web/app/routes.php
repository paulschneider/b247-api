<?php

/*
    |--------------------------------------------------------------------------
    | Version 1
    |--------------------------------------------------------------------------
    |
    |
    */
Route::group(['prefix' => 'v1'], function(){    

    /*
    |--------------------------------------------------------------------------
    | Article
    |--------------------------------------------------------------------------
    |
    |
    */
    # only return the data of the article. Not including the template
    if( Input::get('dataOnly') ) 
    {
        Route::get('articles', 'ArticleController@getWebArticle');   
    }
    # call to grab a static article. This only be used to grab content for pages like About Us, Privacy Policy
    # as it returns a reduced result set of the article content
    else if(Input::get('static')) 
    {
        Route::get('articles', 'ArticleController@getArticle');      
    }
    # get the app version of the article including the HTML template markup
    else 
    {
        Route::get('articles', 'ArticleController@getAppArticle');
    }

    /*
    |--------------------------------------------------------------------------
    | Application Navigation
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::get('app/nav', 'AppNavigationController@index');

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::group(['prefix' => 'category'], function(){
        Route::get('/', 'CategoryController@index');

    	// route aliases as required by mobile apps (or at least requested)
    	Route::get('{categoryId}/{listing}/articles', 'CategoryController@getCategoryArticles'); // these
        Route::get('{categoryId}/{article}/articles', 'CategoryController@getCategoryArticles'); // are
        Route::get('{categoryId}/{directory}/articles', 'CategoryController@getCategoryArticles'); // aliases
        Route::get('{categoryId}/{promotion}/articles', 'CategoryController@getCategoryArticles'); // for

        Route::get('{categoryId}/articles', 'CategoryController@getCategoryArticles'); // this
    });

    /*
    |--------------------------------------------------------------------------
    | Channels
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::group(['prefix' => 'channel'], function(){
        Route::get('{channel}', 'ChannelController@getChannel');
    });

    Route::group(['prefix' => 'subchannel'], function(){
        Route::get('{channel}/{listing}', 'ChannelController@getSubChannel'); // these
        Route::get('{channel}/{article}', 'ChannelController@getSubChannel'); // are
        Route::get('{channel}/{directory}', 'ChannelController@getSubChannel'); // aliases
        Route::get('{channel}/{promotion}', 'ChannelController@getSubChannel'); // for

        Route::get('{channel}/articles', 'ChannelController@getSubChannel'); // this
    });

    /*
    |--------------------------------------------------------------------------
    | Log-in
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::post('login', 'SessionsController@login');
   
    /*
    |--------------------------------------------------------------------------
    | Registration
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::post('register', 'RegisterController@createSubscriber');

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::get('search', 'SearchController@search');

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    |
    |
    */
    
    Route::get('user', 'UserController@getUser');
    Route::get('user/preferences', 'UserController@getPreferences');
    Route::post('user/preferences', 'UserController@setPreferences');
    Route::post('user/password', 'UserController@changeUserPassword');
    Route::post('user/profile', 'UserController@profile');
    Route::post('user/districts', 'UserController@districtPreferences');    
    Route::post('user/promotion/redeem', 'UserController@redeemPromotion');
    Route::post('user/competition/enter', 'UserController@enterCompetition');
        
    /*
    |--------------------------------------------------------------------------
    | Homepage
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');

    /*
    |--------------------------------------------------------------------------
    | Mail
    |--------------------------------------------------------------------------
    |
    |
    */

    Route::get('mail/confirm-subscription', 'MailController@verifyUserIsSubscribed');

    /*
    |--------------------------------------------------------------------------
    | Contact
    |--------------------------------------------------------------------------
    |
    |
    */
   Route::post('contact-enquiry', [ 'as' => 'contact', 'uses' => 'MailController@newContactEnquiry']);
});
