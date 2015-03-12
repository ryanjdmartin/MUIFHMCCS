<?php

class Measurement extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measurements';

    public static function getVelocityData($hood_id, $limit)
    {
        $hood = FumeHood::findOrFail($hood_id);
        $data = array();
        $set = self::where('fume_hood_name', $hood->name)->orderBy('measurement_time', 'desc');
        if ($limit)
            $set = $set->take($limit);

        foreach ($set->get() as $row){
            $data[explode(" ", $row->measurement_time)[1]] = $row->velocity;
        }

        return $data;
    }

    public static function getOvernightSashData($hood_id, $limit)
    {
        $hood = FumeHood::findOrFail($hood_id);
        $data = array();
        $query = "SELECT DATE(measurement_time) AS date, SUM(sash_up) AS sash_up 
                    FROM measurements 
                    WHERE fume_hood_name = '".$hood->name."' 
                        AND HOUR(measurement_time) >= 22
                    GROUP BY DATE(measurement_time)
                    ORDER BY date DESC";

        if ($limit > 0)
            $query .= " LIMIT $limit";

        foreach (DB::select($query) as $row){
            $data[$row->date] = ($row->sash_up > 0 ? 1 : 0);
        }

        return $data;
    }

    public static function getAlarmData($hood_id, $limit)
    {
        $hood = FumeHood::findOrFail($hood_id);
        $data = array();
        $set = self::where('fume_hood_name', $hood->name)->orderBy('measurement_time', 'desc');
        if ($limit)
            $set = $set->take($limit);

        foreach ($set->get() as $row){
            $data[explode(" ", $row->measurement_time)[1]] = $row->alarm;
        }

        return $data;
    }
}
