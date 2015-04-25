<?php

class Room extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rooms';

    function getBuilding(){
        return Building::find($this->building_id);
    }

    function getFumeHoods(){
        return FumeHood::where('room_id', $this->id)->get();
    }

    function getNextFumeHood($last_id){
        return FumeHood::where('room_id', $this->id)->orderBy('name')->skip($last_id)->first();
    }

    function countFumeHoods(){
        return FumeHood::where('room_id', $this->id)->count();
    }
}
