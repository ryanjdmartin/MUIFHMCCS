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

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showHome'));

Route::get('/login', array('as' => 'user.login', 'uses' => 'UserController@showLogin'));
Route::post('/login/dologin', array('as' => 'user.dologin', 'uses' => 'UserController@doLogin'));
Route::get('/logout', array('as' => 'user.logout', 'uses' => 'UserController@logout'));

Route::get('/profile', array('as' => 'user.profile', 'uses' => 'UserController@showProfile'));

Route::controller('password', 'RemindersController');


Route::post('/test', array('as' => 'test', 'uses' => 'HomeController@test'));
Route::get('/buildings', array('as' >= 'buildings', 'uses' => 'HomeController@showBuildings'));
Route::get('/rooms/{building_id}', array('as' >= 'rooms', 'uses' => 'HomeController@showRooms'));
Route::get('/fumehoods/{room_id}', array('as' >= 'fumehoods', 'uses' => 'HomeController@showFumeHoods'));