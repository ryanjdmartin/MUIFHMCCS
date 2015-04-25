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
        $rooms = Room::orderBy('building_id')->orderBy('name')->get();
        return View::make('admin.hoods', array('buildings' => $buildings, 'rooms' => $rooms, 'bld_sel' => $bld_sel));
    }

    public function showUpload(){
        $buildings = Building::all();
        foreach ($buildings as $b){
            $bld_sel[$b->id] = $b->name.' ('.$b->abbv.')';
        }
        return View::make('admin.csv', array('bld_sel' => $bld_sel));
    }

    public function streamAllFumeHoods(){
        $result = array('status' => 0, 'data' => []);
        
        $q = DB::table('fume_hoods')
                ->leftJoin('rooms', 'fume_hoods.room_id', '=', 'rooms.id')
                ->leftJoin('buildings', 'rooms.building_id', '=', 'buildings.id')
                ->orderBy('buildings.abbv')
                ->orderBy('rooms.name')
                ->orderBy('fume_hoods.name')
                ->select('buildings.abbv as building', 'rooms.name as room',
                        'fume_hoods.name as name', 'fume_hoods.model as model',
                        'fume_hoods.install_date as install_date',
                        'fume_hoods.maintenance_date as maintenance_date',
                        'fume_hoods.notes as notes', 'fume_hoods.id as id')
                ->get();

        foreach ($q as $f){
            $result['data'][] = array(
                'building' => $f->building,
                'room' => $f->room,
                'name' => $f->name,
                'model' => $f->model,
                'install_date' => $f->install_date,
                'maintenance_date' => $f->maintenance_date,
                'notes' => $f->notes,
                'id' => $f->id);
        } 

        $result['status'] = 1;
        return Response::json($result);
    }

    public function addBuilding(){
        $name = Input::get('name');
        $abbv = Input::get('abbv');
        Session::flash('mode', 'building');
        
        if (!$name){
            Session::flash('msg', 'ERROR: Building name must not be blank.');
            Session::flash('err', 'add');
            Session::flash('el', 'name');
            return Redirect::route('admin.hoods')->withInput();
        }
        if (!$abbv){
            Session::flash('msg', 'ERROR: Abbreviation must not be blank.');
            Session::flash('err', 'add');
            Session::flash('el', 'abbv');
            return Redirect::route('admin.hoods')->withInput();
        }

        $bldg = new Building;
        $bldg->name = $name;
        $bldg->abbv = $abbv;
        $bldg->save();

        Session::flash('msg', "Building added.");
        return Redirect::route('admin.hoods');
    }

    public function updateBuilding(){
        $name = Input::get('name');
        $abbv = Input::get('abbv');
        $id = Input::get('id');
        Session::flash('mode', 'building');
        
        if (!$name){
            Session::flash('msg', 'ERROR: Building name must not be blank.');
            Session::flash('err', 'edit');
            Session::flash('el', 'name');
            return Redirect::route('admin.hoods')->withInput();
        }
        if (!$abbv){
            Session::flash('msg', 'ERROR: Abbreviation must not be blank.');
            Session::flash('err', 'edit');
            Session::flash('el', 'abbv');
            return Redirect::route('admin.hoods')->withInput();
        }

        $bldg = Building::find($id);
        $bldg->name = $name;
        $bldg->abbv = $abbv;
        $bldg->save();

        Session::flash('msg', "Building ".$abbv." updated.");
        return Redirect::route('admin.hoods');
    }
    
    public function removeBuilding($id){
        $bldg = Building::find($id);
        $abbv = $bldg->abbv;
        $bldg->delete();

        Session::flash('msg', "Building ".$abbv." deleted.");
        return Redirect::route('admin.hoods');
    }

    public function addRoom(){
        $name = Input::get('name');
        $building_id = Input::get('building_id');
        Session::flash('mode', 'room');
        
        if (!$name){
            Session::flash('msg', 'ERROR: Room name must not be blank.');
            Session::flash('err', 'add');
            Session::flash('el', 'name');
            return Redirect::route('admin.hoods')->withInput();
        }

        $room = new Room;
        $room->name = $name;
        $room->building_id = $building_id;
        $room->save();

        Session::flash('msg', "Room added.");
        return Redirect::route('admin.hoods');
    }

    public function removeRoom($id){
        $room = Room::find($id);
        $name = $room->getBuilding()->name." ".$room->name;
        $room->delete();

        Session::flash('msg', "Room ".$name." deleted.");
        return Redirect::route('admin.hoods');
    }

    public function uploadHoods(){
        $csv = Input::file('csv');
        $bldg_id = Input::get('building_id');
        $bldg = Building::find($bldg_id);
        
        if (!$csv->isValid()){
            Session::flash('msg', "File upload failed.");
            return Redirect::route('admin.hoods');
        }
            
        $fh = file($csv->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        unlink($csv->getRealPath());

        $add = [];
        $update = [];

        $headers = explode(',', $fh[0]);
        for ($i = 0; $i < count($headers); $i++){
            $headers[$i] = trim($headers[$i]);
        }

        $room_id = array_search('room', $headers);
        $name_id = array_search('name', $headers);
        $model_id = array_search('model', $headers);
        $install_id = array_search('install_date', $headers);
        $maintenance_id = array_search('maintenance_date', $headers);
        $notes_id = array_search('notes', $headers);

        foreach (array_slice($fh, 1) as $line){
            $line = explode(',',$line);

            $f = array('room' => '', 
                        'name' => '', 
                        'model' => '', 
                        'install_date' => '',
                        'maintenance_date' => '',
                        'notes' => '',
                        'room_id' => 0);
            if ($room_id !== false)
                $f['room'] = trim($line[$room_id]);
            if ($name_id !== false)
                $f['name'] = trim($line[$name_id]);
            if ($model_id !== false)
                $f['model'] = trim($line[$model_id]);
            if ($install_id !== false)
                $f['install_date'] = trim($line[$install_id]);
            if ($maintenance_id !== false)
                $f['maintenance_date'] = trim($line[$maintenance_id]);
            if ($notes_id !== false)
                $f['notes'] = trim($line[$notes_id]);
            
            $r = Room::where('name', $f['room'])->first();   
            if ($r)
                $f['room_id'] = $r->id;

            $db = FumeHood::where('name', $f['name'])->first();
            if (!$db){
                $add[] = $f;
                continue;
            }

            if (!$r || $db->room_id != $f['room_id']){
                $update[] = $f;
                continue;
            }
            if ($db->model != $f['model']){
                $update[] = $f;
                continue;
            }
            if ($db->install_date != $f['install_date']){
                $update[] = $f;
                continue;
            }
            if ($db->maintenance_date != $f['maintenance_date']){
                $update[] = $f;
                continue;
            }
            if ($db->notes != $f['notes']){
                $update[] = $f;
                continue;
            }
            
        }
                   
        return View::make('admin.upload', array('add' => $add, 'update' => $update, 'building' => $bldg));
    }

    public function uploadAddHoods(){
        $result = array('status' => 0, 'room' => '', 'room_id' => 0);
        
        $room_id = Input::get('room_id');
        if (!$room_id){
            
            $r = new Room;
            $r->name = Input::get('room');
            $r->building_id = Input::get('building_id');
            $r->save();
            $room_id = $r->id;
            $result['room'] = $r->name;
            $result['room_id'] = $room_id;
        }

        $f = new FumeHood;
        $f->name = Input::get('name');
        $f->room_id = $room_id;
        $f->model = Input::get('model');
        $f->install_date = Input::get('install_date');
        $f->maintenance_date = Input::get('maintenance_date');
        $f->notes = Input::get('notes');
        $f->save();

        $result['status'] = 1;
        return Response::json($result);
    }

    public function uploadUpdateHoods(){
        $result = array('status' => 0, 'room' => '', 'room_id' => 0);
        
        $room_id = Input::get('room_id');
        if (!$room_id){
            
            $r = new Room;
            $r->name = Input::get('room');
            $r->building_id = Input::get('building_id');
            $r->save();
            $room_id = $r->id;
            $result['room'] = $r->name;
            $result['room_id'] = $room_id;
        }

        $f = FumeHood::where('name', Input::get('name'))->first();
        $f->room_id = $room_id;
        $f->model = Input::get('model');
        $f->install_date = Input::get('install_date');
        $f->maintenance_date = Input::get('maintenance_date');
        $f->notes = Input::get('notes');
        $f->save();

        $result['status'] = 1;
        return Response::json($result);
    }

    public function removeHood($id){
        $f = FumeHood::find($id);
        $name = $f->name;
        $f->delete();

        Session::flash('msg', "Fumehood ".$name." deleted.");
        return Redirect::route('admin.hoods');
    }

    public function downloadHoods(){
        $id = Input::get('building_id');
        $bldg = Building::findOrFail($id);

        $name = $bldg->abbv."_fumehoods_".date("y-m-d_H-i-s").".csv";
        $data = $bldg->getFumeHoods();

        $csv = ['building,room,name,model,install_date,maintenance_date,notes'];

        foreach ($data as $row){
            $csv[] = $row->getBuilding()->abbv.','
                        .$row->getRoom()->name.','
                        .$row['name'].','
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
