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
	    return View::make('buildings');
	}

	public function streamBuildings($last_id)
	{
        $result = array('status' => 0, 'content' => '', 'id' => 0);
		$building = Building::where('id', '>', $last_id)->take(1)->get()->first();
        if ($building){
            $result['status'] = 1;
		    $result['content'] = View::make('parts.building-tile', array('building' => $building))->render();
            $result['id'] = $building->id;
        }
        return Response::json($result);
	}

	public function showRooms($building_id)
	{
        $building = Building::findOrFail($building_id);
		return View::make('rooms', array('building' => $building));
	}

	public function streamRooms($building_id, $last_id)
	{
        $result = array('status' => 0, 'content' => '', 'id' => 0);
		$building = Building::findOrFail($building_id);
		$room = $building->getNextRoom($last_id);
        if ($room){
            $result['status'] = 1;
		    $result['content'] = View::make('parts.room-tile', array('building' => $building, 'room' => $room))->render();
            $result['id'] = $room->id;
        }
        return Response::json($result);
	}

	public function showFumeHoods($room_id)
	{
		$room = Room::findOrFail($room_id);
		return View::make('fumehoods', array('room' => $room));
	}

	public function streamFumeHoods($room_id, $last_id)
	{
        $result = array('status' => 0, 'content' => '', 'id' => 0);
		$room = Room::findOrFail($room_id);
		$fumehood = $room->getNextFumeHood($last_id);
        if ($fumehood){
            $result['status'] = 1;
		    $result['content'] = View::make('parts.fumehood-tile', array('room' => $room, 'fumehood' => $fumehood))->render();
            $result['id'] = $fumehood->id;
        }
        return Response::json($result);
	}
	
}
