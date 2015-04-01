<?php

class Notification extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'notifications';

    public static function getNotifications(){
        $query = "SELECT * FROM notifications n
                    INNER JOIN 
                    (SELECT type, fume_hood_name, max(measurement_time) m
                        FROM notifications
                        GROUP BY type, fume_hood_name)
                    AS s
                    ON s.type = n.type
                        AND s.fume_hood_name = n.fume_hood_name
                        AND s.m = n.measurement_time
                    ORDER BY class DESC, measurement_time DESC"; 

        return DB::select($query);
    }

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
        $query = "SELECT * FROM notifications n
                    INNER JOIN 
                    (SELECT type, fume_hood_name, max(measurement_time) m
                        FROM notifications
                        GROUP BY type, fume_hood_name)
                    AS s
                    ON s.type = n.type
                        AND s.fume_hood_name = n.fume_hood_name
                        AND s.m = n.measurement_time
                    WHERE n.id NOT IN 
                    (SELECT notification_id FROM dismissed_notifications
                      WHERE user_id = $user_id)
                    ORDER BY class DESC, measurement_time DESC"; 

        return DB::select($query);
    }

    /* Gets all historical notifications for a fumehood, unfiltered by user. */
    public static function getHoodNotifications($hood_id){
        $hood = FumeHood::find($hood_id);
        $query = "SELECT * FROM notifications
                    WHERE fume_hood_name = '".$hood->name."'
                    ORDER BY measurement_time DESC"; 

        return DB::select($query);
    }

    public static function countUserNotifications($user_id){
        $ret = array('alert' => 0, 'critical' => 0);
          
        $query = "SELECT class, COUNT(class) AS cnt FROM notifications n
                    INNER JOIN 
                    (SELECT type, fume_hood_name, max(measurement_time) m
                        FROM notifications
                        GROUP BY type, fume_hood_name)
                    AS s
                    ON s.type = n.type
                        AND s.fume_hood_name = n.fume_hood_name
                        AND s.m = n.measurement_time
                    WHERE n.id NOT IN 
                    (SELECT notification_id FROM dismissed_notifications
                      WHERE user_id = $user_id)
                    GROUP BY class"; 

        foreach (DB::select($query) as $row){
            $ret[$row->class] = $row->cnt;       
        }
        return $ret;
    }

    public static function hoodNotificationStatus($hood_id){
        $hood = FumeHood::find($hood_id);
        $query = "SELECT class, COUNT(class) AS cnt FROM notifications n
                    INNER JOIN 
                    (SELECT type, fume_hood_name, max(measurement_time) m
                        FROM notifications
                        WHERE fume_hood_name = '".$hood->name."'
                        GROUP BY type, fume_hood_name)
                    AS s
                    ON s.type = n.type
                        AND s.fume_hood_name = n.fume_hood_name
                        AND s.m = n.measurement_time
                    GROUP BY class
                    ORDER BY class DESC"; 

        foreach (DB::select($query) as $row){
            if ($row->cnt)
                return $row->class;
        }
        return 'opt';
    }

    /* Returns a count of which fumehoods have *any* notifications.
    The highest notification class is returned for each fumehood.*/
    public static function roomNotificationStatus($room_id){
        $ret = array('alert' => 0, 'critical' => 0);
        $query = "SELECT c, COUNT(c) AS cnt FROM
                    (SELECT max(class) as c, fume_hood_name FROM
                    (SELECT class, n.fume_hood_name FROM notifications n
                    INNER JOIN 
                    (SELECT type, fume_hood_name, max(measurement_time) m
                        FROM notifications
                        INNER JOIN fume_hoods ON fume_hood_name = fume_hoods.name 
                        WHERE fume_hoods.room_id = $room_id
                        GROUP BY type, fume_hood_name)
                    AS s
                    ON s.type = n.type
                        AND s.fume_hood_name = n.fume_hood_name
                        AND s.m = n.measurement_time
                    ORDER BY class DESC) as a
                    GROUP BY fume_hood_name) as b
                    GROUP BY c"; 

        foreach (DB::select($query) as $row){
            $ret[$row->c] = $row->cnt;       
        }
        return $ret;
    }

    /* Returns a count of which fumehoods have *any* notifications.
    The highest notification class is returned for each fumehood.*/
    public static function buildingNotificationStatus($building_id){
        $ret = array('alert' => 0, 'critical' => 0);
        $query = "SELECT c, COUNT(c) AS cnt FROM
                    (SELECT max(class) as c, fume_hood_name FROM
                    (SELECT class, n.fume_hood_name FROM notifications n
                    INNER JOIN 
                    (SELECT type, fume_hood_name, max(measurement_time) m
                        FROM notifications
                        INNER JOIN fume_hoods ON fume_hood_name = fume_hoods.name 
                        INNER JOIN rooms ON fume_hoods.room_id = rooms.id 
                        WHERE rooms.building_id = $building_id 
                        GROUP BY type, fume_hood_name)
                    AS s
                    ON s.type = n.type
                        AND s.fume_hood_name = n.fume_hood_name
                        AND s.m = n.measurement_time
                    ORDER BY class DESC) as a
                    GROUP BY fume_hood_name) as b
                    GROUP BY c"; 

        foreach (DB::select($query) as $row){
            $ret[$row->c] = $row->cnt;       
        }
        return $ret;
    }
}
