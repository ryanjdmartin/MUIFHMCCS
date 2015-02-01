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

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showHomeTile'));

Route::get('/tile', array('as' => 'tile', 'uses' => 'HomeController@showHomeTile'));

Route::get('/list', array('as' => 'list', 'uses' => 'HomeController@showHomeList'));

Route::get('/profile', array('as' => 'profile', 'uses' => 'UserController@showProfile'));

Route::post('/test', array('as' => 'test', 'uses' => 'HomeController@test'));