<?php

class Building extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'buildings';

    function getRooms(){
        return Room::where('building_id', $this->id)->get();
    }

    function getFumeHoods(){
        $res = array();
    
        foreach ($this->getRooms() as $room){
            array_merge($res, $room->getFumeHoods());
        }
        return $res;
    }
}
