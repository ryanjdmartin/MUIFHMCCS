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

	public function updateNotification()
	{
        $id = Input::get('id');
        $status = Input::get('status');
        $n = Notification::find($id);
        $n->status = $status;
        $n->updated_by = Auth::User()->id;
        $n->save();

        Session::flash('msg', 'Notification updated.');
        return Redirect::to('/');
	}

}
