<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => ['web']], function() {
    Route::get('/login', 'AuthController@getLogin')->name('login');
    Route::get('/logout', 'AuthController@getLogout')->name('logout');

    Route::post('/login', 'AuthController@postLogin')->name('login.post');

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/', 'DashboardController@getIndex')->name('dashboard');
        Route::resource('/domains', 'DomainController');
        Route::resource('/domains/{domain}/aliases', 'AliasController');
        Route::resource('/domains/{domain}/users', 'UserController');
    });
});

