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

Route::group(array('before' => 'guest'), function() {
    Route::get('/login', array('as' => 'user.login', 'uses' => 'UserController@showLogin'));
    Route::post('/login/dologin', array('as' => 'user.dologin', 'uses' => 'UserController@doLogin'));
});

Route::get('/logout', array('as' => 'user.logout', 'uses' => 'UserController@logout'));
Route::controller('password', 'RemindersController');

Route::get('/monitor', array('as' >= 'monitor', 'uses' => 'HomeController@showMonitor'));
Route::post('/hood/velocity/{hood_id}/{limit}', array('as' >= 'hood.velocity', 'uses' => 'FumeHoodController@getVelocityData'));
Route::post('/hood/sash/{hood_id}/{limit}', array('as' >= 'hood.sash', 'uses' => 'FumeHoodController@getSashData'));
Route::post('/hood/alarm/{hood_id}/{limit}', array('as' >= 'hood.alarm', 'uses' => 'FumeHoodController@getAlarmData'));

//Logged-in routes here
Route::group(array('before' => 'auth'), function() {
    Route::get('/', array('as' => 'home', 'uses' => 'HomeController@showHome'));
    Route::get('/profile', array('as' => 'user.profile', 'uses' => 'UserController@showProfile'));
	Route::post('/profile/updateemail', array('as' => 'user.email', 'uses' => 'UserController@updateEmail'));
	Route::post('/profile/updatepassword', array('as' => 'user.password', 'uses' => 'UserController@updatePassword'));
	Route::post('/profile/updatenotifications', array('as' => 'user.notificationsettings', 'uses' => 'UserController@updateNotificationSettings'));

    Route::get('/notifications', array('as' >= 'notifications', 'uses' => 'NotificationsController@showNotifications'));
    Route::post('/notifications/dismiss', array('as' >= 'notifications.dismiss', 'uses' => 'NotificationsController@dismissNotification'));
    Route::post('/notifications/status', array('as' >= 'notifications.status', 'uses' => 'NotificationsController@updateNotification'));

    Route::get('/buildings', array('as' >= 'buildings', 'uses' => 'HomeController@showBuildings'));
    Route::get('/buildings/stream/{last_id}', array('as' >= 'buildings.stream', 'uses' => 'HomeController@streamBuildings'));

    Route::get('/rooms/{building_id}', array('as' >= 'rooms', 'uses' => 'HomeController@showRooms'));
    Route::get('/rooms/stream/{building_id}/{last_id}', array('as' >= 'rooms.stream', 'uses' => 'HomeController@streamRooms'));

    Route::get('/fumehoods/{room_id}', array('as' >= 'fumehoods', 'uses' => 'HomeController@showFumeHoods'));
    Route::get('/fumehoods/stream/{room_id}/{last_id}', array('as' >= 'fumehoods.stream', 'uses' => 'HomeController@streamFumeHoods'));

    Route::get('/hood/{hood_id}', array('as' >= 'hood', 'uses' => 'FumeHoodController@showHood'));

    Route::post('/toggleview/{tf}', array('as' >= 'toggleview', 'uses' => 'HomeController@toggleView'));
});

//Admin-only routes here
Route::group(array('before' => 'admin'), function(){
    Route::get('/users', array('as' => 'users.view', 'uses' => 'UserController@showUsers'));
    Route::post('/users/add', array('as' => 'users.add', 'uses' => 'UserController@addUser'));
    Route::post('/users/edit', array('as' => 'users.edit', 'uses' => 'UserController@editUser'));
    Route::post('/users/delete', array('as' => 'users.delete', 'uses' => 'UserController@deleteUser'));
    Route::get('/hood/download/{hood_id}', array('as' >= 'hood.download', 'uses' => 'FumeHoodController@downloadData'));
	
	Route::get('/systemsettings', array('as' => 'systemsettings.view', 'uses' => 'SettingsController@showSettings'));
	Route::post('/systemsettings/edit', array('as' => 'systemsettings.edit', 'uses' => 'SettingsController@editSetting'));

});
