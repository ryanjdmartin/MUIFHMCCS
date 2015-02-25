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
        SystemSettings::getSettings();
		return View::make('home');
	}
	public function showBuildings()
	{	
		$buildings = Building::all();
	    return View::make('buildings', array('buildings' => $buildings));
	}

	public function showRooms($building_id)
	{
        $building = Building::findOrFail($building_id);
		$rooms = $building->getRooms();
		return View::make('rooms', array('building' => $building, 'rooms' => $rooms));
	}

	public function showFumeHoods($room_id)
	{
		$room = Room::findOrFail($room_id);
		$fumehoods = $room->getFumeHoods();
		return View::make('fumehoods', array('room' => $room, 'fumehoods' => $fumehoods));
	}

	
}
