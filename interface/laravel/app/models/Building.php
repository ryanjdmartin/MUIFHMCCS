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

    function getNextRoom($last_id){
        return Room::where('building_id', $this->id)->orderBy('name')->skip($last_id)->first();
    }

    function getFumeHoods(){
        $res = array();
    
        foreach ($this->getRooms() as $room){
            foreach ($room->getFumeHoods() as $hood){
                $res[] = $hood;
            }
        }
        return $res;
    }

    function countFumeHoods(){
        $res = 0;
    
        foreach ($this->getRooms() as $room){
            $res += $room->countFumeHoods();
        }
        return $res;
    }
}
