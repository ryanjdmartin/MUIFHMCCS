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

    Route::post('/admin/buildings/add', array('as' => 'admin.buildings.add', 'uses' => 'FumeHoodController@addBuilding'));
    Route::post('/admin/buildings/update', array('as' => 'admin.buildings.update', 'uses' => 'FumeHoodController@updateBuilding'));
    Route::get('/admin/buildings/remove/{id}', array('as' => 'admin.buildings.remove', 'uses' => 'FumeHoodController@removeBuilding'));

    Route::post('/admin/rooms/add', array('as' => 'admin.rooms.add', 'uses' => 'FumeHoodController@addRoom'));
    Route::get('/admin/rooms/remove/{id}', array('as' => 'admin.rooms.remove', 'uses' => 'FumeHoodController@removeRoom'));

    Route::get('/admin/hoods', array('as' => 'admin.hoods', 'uses' => 'FumeHoodController@showHoodManager'));
    Route::post('/admin/upload', array('as' => 'admin.upload', 'uses' => 'FumeHoodController@uploadHoods'));
    Route::post('/admin/upload/rooms', array('as' => 'admin.upload.rooms', 'uses' => 'FumeHoodController@uploadAddRooms'));
    Route::post('/admin/upload/add', array('as' => 'admin.upload.add', 'uses' => 'FumeHoodController@uploadAddHoods'));
    Route::post('/admin/upload/update', array('as' => 'admin.upload.update', 'uses' => 'FumeHoodController@uploadUpdateHoods'));
    Route::post('/admin/upload/remove', array('as' => 'admin.upload.remove', 'uses' => 'FumeHoodController@uploadRemoveHoods'));
    Route::post('/admin/download', array('as' => 'admin.download', 'uses' => 'FumeHoodController@downloadHoods'));
});
