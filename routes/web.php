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

    Route::get('/registration', 'RegistrationController@create')->name('registration.create');
    Route::post('/registration', 'RegistrationController@store')->name('registration.store');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', 'DashboardController@getIndex')->name('dashboard');
    Route::get('/logout', 'AuthController@getLogout')->name('logout');

    Route::get('/password', 'PasswordController@edit')->name('password.edit');
    Route::post('/password', 'PasswordController@update')->name('password.update');

    Route::group(['middleware' => ['admin']], function() {
        Route::resource('/domains', 'DomainController');
        Route::resource('/domains/{domain}/aliases', 'AliasController');
        Route::resource('/domains/{domain}/users', 'UserController');
    });
});

