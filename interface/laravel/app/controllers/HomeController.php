<?php

class HomeController extends BaseController {

	public function showHome()
	{
        SystemSettings::getSettings();
        Session::put('isTileView', true);
		return View::make('home');
	}

	public function showBuildings()
	{	
	    return View::make('buildings');
	}

	public function streamBuildings($last_id)
	{
        
		if(Session::get('isTileView')){
			$result = array('status' => 0, 'content' => '', 'id' => 0, 'isTileView' => 1);
	        $building = Building::where('id', '>', $last_id)->take(1)->get()->first();
	        if ($building){
	            $result['status'] = 1;
	 			$result['content'] = View::make('parts.building-tile', array('building' => $building))->render();
	            $result['id'] = $building->id;
	        }
		}
		else{
			$result = array('status' => 0, 'content' => '', 'id' => 0, 'isTileView' => 0 );
	        $fumehood = DB::table('fume_hoods')            
	        ->leftJoin('rooms', 'rooms.id', '=', 'fume_hoods.room_id')
	       	->leftJoin('buildings', 'rooms.building_id', '=', 'buildings.id' )
	        ->select('fume_hoods.id', 'fume_hoods.name', 'fume_hoods.room_id', 'rooms.name as room_name',
	        	'buildings.id as building_id', 'buildings.abbv as building_name',
	            'fume_hoods.model', 'fume_hoods.install_date', 
	            'fume_hoods.maintenance_date', 'fume_hoods.notes' )
	        ->where('fume_hoods.id', '>', $last_id)->take(1)->first();
	        if($fumehood){
	        	$status = Notification::hoodNotificationStatus($fumehood->id);
	        	$data = Measurement::where('fume_hood_name', $fumehood->name)->orderBy('measurement_time', 'desc')->first();
	        	$result['status'] = 1;
				$result['content'] = View::make('parts.building-list-item', 
										array('fumehood' => $fumehood, 'status' => $status, 'data' => $data))->render();
				$result['id'] = $fumehood->id;
	        }

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
		if(Session::get('isTileView')){
	        $result = array('status' => 0, 'content' => '', 'id' => 0, 'isTileView' => 1);
			$building = Building::findOrFail($building_id);
			$room = $building->getNextRoom($last_id);
	        if ($room){
	            $result['status'] = 1;
			    $result['content'] = View::make('parts.room-tile', array('building' => $building, 'room' => $room))->render();
	            $result['id'] = $room->id;
	        }
		}
		else{
			$result = array('status' => 0, 'content' => '', 'id' => 0, 'isTileView' => 0 );
	        $fumehood = DB::table('fume_hoods')            
	        ->leftJoin('rooms', 'rooms.id', '=', 'fume_hoods.room_id')
	        ->select('fume_hoods.id', 'fume_hoods.name', 'fume_hoods.room_id', 'rooms.name as room_name',
	            'fume_hoods.model', 'fume_hoods.install_date', 
	            'fume_hoods.maintenance_date', 'fume_hoods.notes' )
	        ->where('fume_hoods.id', '>', $last_id)->where('rooms.building_id', $building_id)->take(1)->first();
	        if($fumehood){
	        	$status = Notification::hoodNotificationStatus($fumehood->id);
	        	$data = Measurement::where('fume_hood_name', $fumehood->name)->orderBy('measurement_time', 'desc')->first();
	        	$result['status'] = 1;
				$result['content'] = View::make('parts.room-list-item', 
										array('fumehood' => $fumehood, 'status' => $status, 'data' => $data))->render();
				$result['id'] = $fumehood->id;
	        }

		}

        return Response::json($result);
	}

	public function showFumeHoods($room_id)
	{
		$room = Room::findOrFail($room_id);
		return View::make('fumehoods', array('room' => $room));
	}

	public function toggleView($tf)
	{
		Session::put('isTileView', $tf);
	}

	public function streamFumeHoods($room_id, $last_id)
	{
		if(Session::get('isTileView')){
	        $result = array('status' => 0, 'content' => '', 'id' => 0, 'isTileView' => 1);
			$room = Room::findOrFail($room_id);
			$fumehood = $room->getNextFumeHood($last_id);
	        if ($fumehood){
	            $result['status'] = 1;
			    $result['content'] = View::make('parts.fumehood-tile', array('room' => $room, 'fumehood' => $fumehood))->render();
	            $result['id'] = $fumehood->id;
	        }
    	}
    	else{
			$result = array('status' => 0, 'content' => '', 'id' => 0, 'isTileView' => 0 );
	        $fumehood = DB::table('fume_hoods')            
	        ->select('fume_hoods.id', 'fume_hoods.name', 'fume_hoods.room_id',
	            'fume_hoods.model', 'fume_hoods.install_date', 
	            'fume_hoods.maintenance_date', 'fume_hoods.notes' )
	        ->where('fume_hoods.id', '>', $last_id)->where('fume_hoods.room_id', $room_id)->take(1)->first();
	        if($fumehood){
	        	$status = Notification::hoodNotificationStatus($fumehood->id);
	        	$data = Measurement::where('fume_hood_name', $fumehood->name)->orderBy('measurement_time', 'desc')->first();
	        	$result['status'] = 1;
				$result['content'] = View::make('parts.fumehood-list-item', 
										array('fumehood' => $fumehood, 'status' => $status, 'data' => $data))->render();
				$result['id'] = $fumehood->id;
	        }

		}

        return Response::json($result);
	}

	public function showMonitor()
	{
        $notifications = Notification::getNotifications();
        $critical = [];
        $alert = [];
        foreach ($notifications as $n){
            if ($n->class == 'critical' && $n->status != 'resolved')
                $critical[] = $n;
            else if ($n->class == 'alert' && $n->status != 'resolved')
                $alert[] = $n;
        }

	    return View::make('monitor', array('critical' => $critical, 'alert' => $alert));
	}
}
