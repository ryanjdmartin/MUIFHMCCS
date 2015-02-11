<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showHome()
	{
		return View::make('home');
	}

	public function test()
	{
		return "we reached here";
	}
	public function showBuildings()
	{
	    return View::make('buildings');
	}
	public function showRooms($building_id)
	{
		return View::make('rooms', array('building_id' => $building_id));
	}
	public function showFumeHoods($room_id)
	{
		return View::make('fumehoods', array('room_id' => $room_id));
	}

}
