<?php

class FumeHoodController extends BaseController {

	public function showHood($hood_id)
	{
        $hood = FumeHood::findOrFail($hood_id);
        $data = Measurement::where('fume_hood_name', $hood->name)->orderBy('measurement_time', 'desc')->first();
        $notifications = Notification::getHoodNotifications($hood_id); 

		return View::make('hood', array('hood' => $hood, 'data' => $data, 'notifications' => $notifications));
	}

    public function getVelocityData($hood_id)
    {
        return Measurement::getVelocityData($hood_id);
    }

    public function getSashData($hood_id)
    {
        return Measurement::getSashData($hood_id);
    }

    public function getAlarmData($hood_id)
    {
        return Measurement::getAlarmData($hood_id);
    }
}
