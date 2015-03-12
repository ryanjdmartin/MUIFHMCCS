<?php

class FumeHoodController extends BaseController {

	public function showHood($hood_id)
	{
        $hood = FumeHood::findOrFail($hood_id);
        $data = Measurement::where('fume_hood_name', $hood->name)->orderBy('measurement_time', 'desc')->first();
        $notifications = Notification::getHoodNotifications($hood_id); 

		return View::make('hood', array('hood' => $hood, 'data' => $data, 'notifications' => $notifications));
	}

    public function getVelocityData($hood_id, $limit)
    {
        return Response::json(Measurement::getVelocityData($hood_id, $limit));
    }

    public function getSashData($hood_id, $limit)
    {
        return Response::json(Measurement::getOvernightSashData($hood_id, $limit));
    }

    public function getAlarmData($hood_id, $limit)
    {
        return Response::json(Measurement::getAlarmData($hood_id, $limit));
    }
}
