<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'WallController@home');

Route::get('/signin', function () {
    return view('signin');
});
//POST route
Route::post('signin', 'AccountController@login');

Route::get('/signup', function () {
    return view('signup');
});
Route::post('signup', 'AccountController@register');

Route::get('/logout', 'AccountController@logout');

Route::get('/facebook', 'AccountController@facebook');
Route::get('/callback_facebook', 'AccountController@callback_facebook');


// Homepage related
Route::get('/wall', 'WallController@home');
