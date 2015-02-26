<?php

class Notification extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'notifications';

    /** 
     * Gets all pertinent notifications, then 
     * filters out by the current user's dismissed list.
     * 
     * It is important to filter out the dismissed after the result
     * is fetched, so that we are still only pulling the latest 
     * notifications for that type. Otherwise, previous notifications
     * could be dredged up even if they are irrelevant (i.e. part of
     * the same lengthy error).
     */
    public static function getUserNotifications($user_id){
        $query = "SELECT * FROM 
                    (SELECT * FROM notifications 
                    GROUP BY class, type, fume_hood_name
                    HAVING max(measurement_time)
                    ORDER BY class DESC, measurement_time) 
                AS n WHERE n.id NOT IN 
                    (SELECT notification_id FROM dismissed_notifications
                    WHERE user_id = $user_id)";

        return DB::select($query);
    }

    /* Gets all notifications for a fumehood, unfiltered by user. */
    public static function getHoodNotifications($hood_id){
        $hood = FumeHood::find($hood_id);
        $query = "SELECT * FROM notifications 
                    WHERE fume_hood_name = ".$hood->name."
                    GROUP BY class, type, fume_hood_name
                    HAVING max(measurement_time)
                    ORDER BY class DESC, measurement_time"; 

        return DB::select($query);
    }

    public static function countUserNotifications($user_id){
        $ret = array('alert' => 0, 'critical' => 0);
          
        $query = "SELECT class, COUNT(class) AS cnt FROM 
                    (SELECT * FROM notifications 
                    GROUP BY class, type, fume_hood_name
                    HAVING max(measurement_time)
                    ORDER BY class DESC, measurement_time) 
                AS n WHERE n.id NOT IN 
                    (SELECT notification_id FROM dismissed_notifications
                    WHERE user_id = $user_id)
                GROUP BY class";

        foreach (DB::select($query) as $row){
            $ret[$row->class] = $row->cnt;       
        }
        return $ret;
    }

    public static function countHoodNotifications($hood_id){
        $hood = FumeHood::find($hood_id);
        $ret = array('alert' => 0, 'critical' => 0);
        $query = "SELECT class, count(class) AS cnt FROM
                    (SELECT class FROM notifications 
                    WHERE fume_hood_name = ".$hood->name."
                    GROUP BY class, type, fume_hood_name
                    HAVING max(measurement_time)
                    ORDER BY class DESC, measurement_time)
                AS n GROUP BY class"; 

        foreach (DB::select($query) as $row){
            $ret[$row->class] = $row->cnt;       
        }
        return $ret;
    }

    /* Returns a count of which fumehoods have *any* notifications.
    The highest notification class is returned for each fumehood.*/
    public static function roomNotificationStatus($room_id){
        $ret = array('alert' => 0, 'critical' => 0);
        $query = "SELECT class, count(class) AS cnt FROM
                    (SELECT class FROM notifications 
                    INNER JOIN fume_hoods ON fume_hood_name = fume_hoods.name
                    WHERE fume_hoods.room_id = $room_id
                    GROUP BY class, type, fume_hood_name
                    HAVING max(measurement_time)
                    ORDER BY class DESC, measurement_time)
                AS n GROUP BY class"; 

        foreach (DB::select($query) as $row){
            $ret[$row->class] = $row->cnt;       
        }
        return $ret;
    }

    /* Returns a count of which fumehoods have *any* notifications.
    The highest notification class is returned for each fumehood.*/
    public static function buildingNotificationStatus($building_id){
        $ret = array('alert' => 0, 'critical' => 0);
        $query = "SELECT class, count(class) AS cnt FROM
                    (SELECT class FROM notifications 
                    INNER JOIN fume_hoods ON fume_hood_name = fume_hoods.name
                    INNER JOIN rooms ON fume_hoods.room_id = rooms.id
                    WHERE rooms.building_id = $building_id
                    GROUP BY fume_hood_name
                    HAVING max(measurement_time)
                    ORDER BY class DESC, measurement_time)
                AS n GROUP BY class"; 

        foreach (DB::select($query) as $row){
            $ret[$row->class] = $row->cnt;       
        }
        return $ret;
    }
}
