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
		//Probably will put this in logout later
		Session::forget('breadcrumbs');
		//breadcrumbs indexes are an array of two values ['name of building, room or fumehood', 'url to that place']
		Session::push('breadcrumbs', ['Buildings', '/buildings/']); 
	
		$buildings = Building::all();
	    return View::make('buildings', array('buildings' => $buildings));
	}

	public function showRooms($building_id)
	{
        $building = Building::findOrFail($building_id);
		$rooms = $building->getRooms();
		//$building_name = DB::table('buildings')->where('id', '=', $building_id)->get()->name;
		//Session::push('breadcrumbs', [$building_name, '/rooms/'.$building_id]); 
		return View::make('rooms', array('building_id' => $building_id, 'rooms' => $rooms));
	}

	public function showFumeHoods($room_id)
	{
        $room = Room::findOrFail($room_id);
		$fumehoods = $room->getFumeHoods();
        $room_name = $room->name; 
		Session::push('breadcrumbs', [$room_name, '/rooms/'.$room_id]);
		return View::make('fumehoods', array('room_id' => $room_id, 'fumehoods' => $fumehoods));
	}
}
