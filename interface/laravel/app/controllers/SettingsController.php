<?php

class SettingsController extends BaseController {

	public function showSettings()
	{
        $user_types = array();
		
		$count = 0;
        foreach (head(SystemSettings::all())[0] as $key => $value){
			$user_types[$count] = $key;
			$count++;
        }

		return View::make('systemsettings', array('system_settings' => SystemSettings::all(), 'user_types' => $user_types));
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