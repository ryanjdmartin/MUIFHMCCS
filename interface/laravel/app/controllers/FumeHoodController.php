<?php

class FumeHoodController extends BaseController {

	public function showHood($hood_id)
	{
        $hood = FumeHood::findOrFail($hood_id);
        $data = Measurement::where('fume_hood_name', $hood->name)->orderBy('measurement_time', 'desc')->first();
        $notifications = Notification::getHoodNotifications($hood_id); 

		return View::make('hood', array('hood' => $hood, 'data' => $data, 'notifications' => $notifications));
	}

    public function getVelocityData($hood_id, $limit)
    {
        return Response::json(Measurement::getVelocityData($hood_id, $limit));
    }

    public function getSashData($hood_id, $limit)
    {
        return Response::json(Measurement::getOvernightSashData($hood_id, $limit));
    }

    public function getAlarmData($hood_id, $limit)
    {
        return Response::json(Measurement::getAlarmData($hood_id, $limit));
    }

    public function downloadData($hood_id)
    {
        $hood = FumeHood::findOrFail($hood_id);
        $name = $hood->getBuilding()->abbv."_".$hood->getRoom()->name."_fumehood_".$hood->name."_data.csv";

        $data = Measurement::where('fume_hood_name', $hood->name)->orderBy('measurement_time')->get();

        $csv = ['measurement_time,velocity,alarm,sash_up'];

        foreach ($data as $row){
            $csv[] = $row['measurement_time'].','
                        .$row['velocity'].','
                        .$row['alarm'].','
                        .$row['sash_up'];
        }

        $fname = storage_path().'/'.time().$name;
        file_put_contents($fname, implode("\n", $csv));
        
        App::finish(function($request, $response) use ($fname)
        {
            unlink($fname);
        });

        $headers = array(
              'Content-Type: text/csv',
        );
               
        return Response::download($fname, $name, $headers);
    }

    public function showHoodManager(){
        $buildings = Building::all();
        $bld_sel = [];
        foreach ($buildings as $b){
            $bld_sel[$b->id] = $b->name.' ('.$b->abbv.')';
        }
        $rooms = Room::all();
        return View::make('admin.hoods', array('buildings' => $buildings, 'rooms' => $rooms, 'bld_sel' => $bld_sel));
    }

    public function addBuilding(){
    }

    public function updateBuilding(){
    }
    
    public function removeBuilding($id){
    }

    public function addRoom(){
    }

    public function removeRoom($id){
    }

    public function uploadAddRooms(){
        return Response::json(array('success' => 1));
    }

    public function uploadAddHoods(){
        return Response::json(array('success' => 1));
    }

    public function uploadUpdateHoods(){
        return Response::json(array('success' => 1));
    }

    public function uploadRemoveHoods(){
        return Response::json(array('success' => 1));
    }

    public function downloadHoods(){
        $id = Input::get('building_id');
        $bldg = Building::findOrFail($id);

        $name = $bldg->abbv."_fumehoods_".date("y-m-d_H-i-s").".csv";
        $data = $bldg->getFumeHoods();

        $csv = ['name,room_name,model,install_date,maintenance_date,notes'];

        foreach ($data as $row){
            $csv[] = $row['name'].','
                        .$row->getRoom()->name().','
                        .$row['model'].','
                        .$row['install_date'].','
                        .$row['maintenance_date'].','
                        .$row['notes'];
        }

        $fname = storage_path().'/'.time().$name;
        file_put_contents($fname, implode("\n", $csv));
        
        App::finish(function($request, $response) use ($fname)
        {
            unlink($fname);
        });

        $headers = array(
              'Content-Type: text/csv',
        );
               
        return Response::download($fname, $name, $headers);

    }
}
