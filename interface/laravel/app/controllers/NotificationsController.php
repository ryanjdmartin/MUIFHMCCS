<?php

class NotificationsController extends BaseController {

	public function showNotifications()
	{
        $notifications = Notification::getUserNotifications(Auth::User()->id);
        $counts = Notification::countUserNotifications(Auth::User()->id);

	    return View::make('notifications', array('notifications' => $notifications, 'counts' => $counts));
	}
	public function dismissNotification()
	{
        $id = Input::get('id');
        $dismiss = new DismissedNotification;
        $dismiss->notification_id = $id;
        $dismiss->user_id = Auth::User()->id;
        $dismiss->save();
        Session::flash('msg', 'Notification dismissed.');
        return Redirect::to('/');
	}

}
