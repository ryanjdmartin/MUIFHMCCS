<?php

class FumeHood extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fume_hoods';

    function getRoom(){
        return Room::find($this->room_id);
    }

    function getBuilding(){
        return Building::find($this->getRoom()->id);
    }
}
