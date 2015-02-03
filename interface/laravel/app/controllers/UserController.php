<?php

class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showProfile()
	{
		return View::make('user.profile');
	}

	public function showLogin()
	{
		return View::make('user.login');
	}

	public function doLogin()
	{
        $email = Input::get('email');   
        $password = Input::get('password');   
        $remember = Input::get('remember_me') == 'true';

        if (Auth::attempt(array('email' => $email, 'password' => $password), $remember))
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
