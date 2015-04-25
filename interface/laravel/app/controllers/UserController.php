<?php

class UserController extends BaseController {

	public function showProfile()
	{
		$user_notifications = array();
		
		foreach(NotificationSetting::where('user_id', Auth::user()->id)->get() as $setting) {
			$user_notifications[$setting->room_id] = array('critical' => $setting->critical, 'alert' => $setting->alert);	
		}
		
		return View::make('user.profile', array('notification_settings' => $user_notifications));
	}

	public function showUsers()
	{
        $user_types = array();

        foreach (UserType::all() as $type){
            $user_types[$type->id] = $type->name;
        }

		return View::make('user.view', array('users' => User::all(), 'user_types' => $user_types));
	}

	public function addUser()
    {
        $email = Input::get('email');
        $user_type = Input::get('user_type');
        Session::flash('email', $email);
        Session::flash('user_type', $user_type);
        
        if (!$email){
            Session::flash('msg', 'Enter a valid email address.');
            Session::flash('err', 'add');
            return Redirect::route('users.view');
        }
        if (User::where('email', $email)->count()){
            Session::flash('msg', 'Email in use. Enter another email.');
            Session::flash('err', 'add');
            return Redirect::route('users.view');
        }


        $user = new User;
        $user->email = $email;
        $user->user_type_id = $user_type;
        $password = str_random(10);
        $user->password = Hash::make($password);
        $user->save();

        Mail::send('emails.auth.newuser', array('email' => $email, 'password' => $password), function($message) use ($email){
            $message->to($email)
                    ->subject('McMaster FMS Account Created');
        });

        Session::flash('msg', "User $email added.");
        return Redirect::route('users.view');
	}

	public function editUser()
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

	public function deleteUser()
    {
        $id = Input::get('id');
        $user = User::find($id);
        $email = $user->email;
        $user->delete();

        Session::flash('msg', "User $email deleted.");
        return Redirect::route('users.view');
	}
	
	
	public function updateEmail()
    {
        $id = Input::get('id');
        $email = Input::get('email');
        $current_password = Input::get('password');
        Session::flash('email', $email);
        
        if (!$email){
            Session::flash('msg', 'Enter a valid email address.');
            Session::flash('err', 'email');
            return Redirect::route('user.profile');
        }

        $user = User::find($id);
        if ($email != $user->email && User::where('email', $email)->count()){
            Session::flash('msg', 'Email in use. Enter another email.');
            Session::flash('err', 'email');
            return Redirect::route('user.profile');
        }

		if (Auth::attempt(array('email' => $user->email, 'password' => $current_password))) {
			$user->email = $email;
			$user->save();
			Session::flash('msg', "Email updated to $email.");
			return Redirect::route('user.profile');
		}
		else {
			Session::flash('msg', 'Incorrect password.');
			Session::flash('err', 'email');
			return Redirect::route('user.profile');		
		}

	}
	
	
		public function updatePassword()
    {
        $id = Input::get('id');
        $new_password = Input::get('new_password');
		$new_password_confirm = Input::get('new_password_confirm');
        $current_password = Input::get('old_password_confirm');
		
        if (!$new_password and !$new_password_confirm){
            Session::flash('msg', 'Empty password is not acceptable.');
            Session::flash('err', 'password');
            return Redirect::route('user.profile');
        }
		elseif (!$current_password) {
			Session::flash('msg', 'Empty current password.');
			Session::flash('err', 'password');
			return Redirect::route('user.profile');
		}
		
		if ($new_password != $new_password_confirm) {
			Session::flash('msg', 'New password does not match confirm password.');
			Session::flash('err', 'password');
			return Redirect::route('user.profile');
		}

		$user = User::find($id);
		if (Auth::attempt(array('email' => $user->email, 'password' => $current_password))) {
			$user->password = Hash::make($new_password);
			$user->save();
			Session::flash('msg', 'Password updated successfully.');
			return Redirect::route('user.profile');
		}
		else {
			Session::flash('msg', 'Incorrect current password.');
			Session::flash('err', 'password');
			return Redirect::route('user.profile');		
		}

	}	
	
	
		public function updateNotificationSettings()
    {
		
		$id = Input::get('id');
		$input = Input::except('_token', 'id');
		
		$current_settings = array();
		$new_rows = array();
		$update_rows = array();
		$delete_rows = array();
		
		//Generates a shorthand array of existing settings.
		foreach (NotificationSetting::where('user_id', $id)->get() as $setting) {
			$current_settings[$setting->room_id] = array('critical' => $setting->critical, 'alert' => $setting->alert, 'id' => $setting->id);
		}

		//Very long logic to generate new/update/delete arrays.
		foreach (Room::all() as $room) {
			//Room setting if there's a current setting, else 0.
			$room_setting = array_get($current_settings, $room->id, 0);
			$critical = array_get($input, $room->id.'_critical', 0);
			$alert = array_get($input, $room->id.'_alert', 0);
			

			if ($room_setting) {
				//If there's already a setting for this user/room in the database....
				
				if ($critical or $alert) {
					//And at least one of the flags (alert/critical) is set...
					
					if ($critical == $current_settings[$room->id]['critical'] and $critical == $current_settings[$room->id]['alert']) {
						//If they're the same, do nothing.
					}
					else {
						//Update the existing database setting.
						$update_rows[$room->id] = array('critical' => (boolean)$critical, 'alert' => (boolean)$alert);
					}
				}
				else {
					//If neither flag is set AND there's something in the DB, delete the offending row.
					$delete_rows[] = $room->id;
				}
			}
			else {
				//If no setting in the database already....
				if ($critical or $alert) {
					//If one of the flags is set, create a setting in the db.
					$new_rows[$room->id] = array('critical' => (boolean)$critical, 'alert' => (boolean)$alert);
				}
			}
		}
		
		
		//Perform the updates based on the new/update/delete arrays.
		foreach ($new_rows as $room => $new_row) {
		
			$setting = new NotificationSetting;
			$setting->critical = $new_row['critical'];
			$setting->alert = $new_row['alert'];
			$setting->room_id = $room;
			$setting->user_id = $id;
			$setting->save();
		}
		
		foreach ($update_rows as $room => $update_row) {
			
			$setting = NotificationSetting::find($current_settings[$room]['id']);
			$setting->critical = $update_row['critical'];
			$setting->alert = $update_row['alert'];
			$setting->save();		
		}
		
		foreach ($delete_rows as $delete_row) {
		
			$setting = NotificationSetting::find($current_settings[$delete_row]['id']);
			$setting->delete();	
		}
		
		
		
		
		Session::flash('msg', 'Notification settings updated.');
		return Redirect::route('user.profile');
	
	}	
	
	

	public function showLogin()
	{
		return View::make('user.login');
	}

	public function doLogin()
	{
        $email = Input::get('email');
        $password = Input::get('password');
        
        if (Auth::attempt(array('email' => $email, 'password' => $password)))
        {
            return Redirect::to('/')->with('msg', 'Logged in.');
        }
        return Redirect::to('login')->with('msg', 'Invalid email or password');   
	}

    public function logout()
    {
        Auth::logout();
        return Redirect::to('login')->with('msg', 'Logged out.');
    }

}
