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

	public function editSettings()
    {
        $id = Input::get('id');
        $email = Input::get('email');
        $user_type = Input::get('user_type');
        Session::flash('id', $id);
        Session::flash('email', $email);
        Session::flash('user_type', $user_type);
        
        if (!$email){
            Session::flash('msg', 'Enter a valid email address.');
            Session::flash('err', 'edit');
            return Redirect::route('users.view');
        }

        $user = User::find($id);
        if ($email != $user->email && User::where('email', $email)->count()){
            Session::flash('msg', 'Email in use. Enter another email.');
            Session::flash('err', 'edit');
            return Redirect::route('users.view');
        }

        $user->email = $email;
        $user->user_type_id = $user_type;
        $user->save();

        Session::flash('msg', "User $email updated.");
        return Redirect::route('users.view');
	}
	
}