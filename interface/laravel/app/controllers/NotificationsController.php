<?php

class NotificationsController extends BaseController {

	public function showNotifications()
	{
        $notifications = Notification::getUserNotifications(Auth::User()->id);

	    return View::make('notifications', array('notifications' => $notifications));
	}

}
