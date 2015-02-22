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
}
