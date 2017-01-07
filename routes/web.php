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

Route::get('/terms', 'LegalController@tos')->name('legal.tos');

Route::group(['middleware' => ['guest']], function() {
    Route::get('/login', 'AuthController@getLogin')->name('login');
    Route::post('/login', 'AuthController@postLogin')->name('login.post');

    Route::resource('/user', 'UserController', ['only' => ['create', 'store']]);
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', 'DashboardController@getIndex')->name('dashboard');
    Route::get('/logout', 'AuthController@getLogout')->name('logout');

    Route::resource('/user', 'UserController', ['except' => ['index', 'create', 'store', 'destroy']]);
    Route::resource('/user.alias', 'User\AliasController', ['except' => 'show', 'edit', 'update']);
    Route::resource('/user.alias.verify', 'VerificationController', ['only' => 'update', 'patch']);

    Route::group([
        'middleware' => ['admin'],
        'namespace' => 'Admin'
    ], function() {
        Route::resource('/domain', 'DomainController');
        Route::resource('/domain.alias', 'AliasController');
        Route::resource('/domain.user', 'UserController');
    });
});

