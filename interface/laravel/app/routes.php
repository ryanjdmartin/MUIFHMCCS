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

//Authenticated routes
Route::group(array('before' => 'auth'), function(){
    Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showHome'));
    Route::get('/profile', array('as' => 'user.profile', 'uses' => 'UserController@showProfile'));
});

//Admin routes
Route::group(array('before' => 'admin'), function(){
});

Route::get('/login', array('as' => 'user.login', 'uses' => 'UserController@showLogin'));
Route::post('/login/dologin', array('as' => 'user.dologin', 'uses' => 'UserController@doLogin'));
Route::get('/logout', array('as' => 'user.logout', 'uses' => 'UserController@logout'));

Route::controller('password', 'RemindersController');
