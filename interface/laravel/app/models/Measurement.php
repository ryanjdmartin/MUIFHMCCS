<?php

class Measurement extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measurements';

    public static function getVelocityData($hood_id)
    {
        $hood = FumeHood::findOrFail($hood_id);
        $data = array();
        foreach (self::where('fume_hood_name', $hood->name)
            ->orderBy('measurement_time', 'desc')->take(100)->get() as $row){
            $data[$row->measurement_time] = $row->velocity;
        }

        return $data;
    }

    public static function getSashData($hood_id)
    {
        $hood = FumeHood::findOrFail($hood_id);
        $data = array();
        foreach (self::where('fume_hood_name', $hood->name)
            ->orderBy('measurement_time', 'desc')->take(100)->get() as $row){
            $data[$row->measurement_time] = $row->sash_up;
        }

        return $data;
    }

    public static function getAlarmData($hood_id)
    {
        $hood = FumeHood::findOrFail($hood_id);
        $data = array();
        foreach (self::where('fume_hood_name', $hood->name)
            ->orderBy('measurement_time', 'desc')->take(100)->get() as $row){
            $data[$row->measurement_time] = $row->alarm;
        }

        return $data;
    }
}
