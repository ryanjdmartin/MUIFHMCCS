<?php

class SettingsController extends BaseController {

	public function showSettings()
	{

		$settings_list = array( 
			array( "db_ident" => "critical_max_velocity", 
				  "name" => "Critical Max Velocity",
				  "units" => "ft3/min" 
				),
			array( "db_ident" => "critical_min_velocity", 
				  "name" => "Critical Min Velocity",
				  "units" => "ft3/min" 
				),
			array( "db_ident" => "alert_max_velocity", 
				  "name" => "Alert Max Velocity",
				  "units" => "ft3/min" 
				),
			array( "db_ident" => "alert_min_velocity", 
				  "name" => "Alert Min Velocity",
				  "units" => "ft3/min" 
				),
			array( "db_ident" => "critical_resend_hours", 
				  "name" => "Critical Resend Frequency",
				  "units" => "hours" 
				),
			array( "db_ident" => "alert_resend_hours", 
				  "name" => "Alert Resend Frequency",
				  "units" => "hours" 
				)
		);
		

		return View::make('systemsettings', array('system_settings' => SystemSettings::getSettings(), 'settings_list' => $settings_list));
	}

	
	
	public function editSetting()
    {
        $input = Input::except('_token');
		$critical_min_velocity;
		$alert_max_velocity;
		$alert_min_velocity;
		$critical_resend_hours;
		$alert_resend_hours;
		
		$updated = SystemSettings::getSettings();
		
		foreach ($input as $inputlabel => $inputval) {
			if (!is_numeric($inputval)){
				Session::flash('msg', 'Non-numeric input for '.$inputlabel);
				Session::flash('err', 'non_numeric');
				return Redirect::route('systemsettings.view');
			}
			else {
				Session::flash($inputlabel, $inputval);
			}
		}
		
		SystemSettings::saveSettings($input);
		
        Session::flash('msg', "Values updated.");
        return Redirect::route('systemsettings.view');
	}
	
}