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
		$buildings = DB::table('buildings')->get();
	    return View::make('buildings', array('buildings' => $buildings));
	}

	public function showRooms($building_id)
	{
		$rooms = DB::table('rooms')->where('building_id', '=', $building_id)->get();
		$building = Building::findorFail($building_id);
		return View::make('rooms', array('building' => $building, 'rooms' => $rooms));
	}

	public function showFumeHoods($room_id)
	{
		$fumehoods = DB::table('fume_hoods')->where('room_id', '=', $room_id)->get();
		$room = Room::findorFail($room_id);
		return View::make('fumehoods', array('room' => $room, 'fumehoods' => $fumehoods));
	}

	public function showHood($hood_id)
	{
		$hood = FumeHood::findorFail($hood_id);
		return View::make('hood', array('hood' => $hood));
	}

}
