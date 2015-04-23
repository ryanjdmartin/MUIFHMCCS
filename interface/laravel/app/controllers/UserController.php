<?php

class UserController extends BaseController {

	public function showProfile()
	{
		return View::make('user.profile');
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
        Session::flash('id', $id);
        Session::flash('email', $email);
        
        if (!$email){
            Session::flash('msg', 'Enter a valid email address.');
            Session::flash('err', 'edit');
            return Redirect::route('user.profile');
        }

        $user = User::find($id);
        if ($email != $user->email && User::where('email', $email)->count()){
            Session::flash('msg', 'Email in use. Enter another email.');
            Session::flash('err', 'edit');
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
			Session::flash('err', 'wrongpass');
			return Redirect::route('user.profile');		
		}

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
