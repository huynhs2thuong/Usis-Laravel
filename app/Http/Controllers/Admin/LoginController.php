<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Cache;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/@dmin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		// echo '<pre>';
		// var_dump($_POST);
		// $user = \App\User::where('email', $_POST['email'])->first();
		// $user->password = \Hash::make($_POST['password']);
		// $user->save();
		// var_dump($user);
		// exit();

        $this->middleware('guest.admin', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected function user() {
        return Auth::user();
    }

    public function logout(Request $request) {
        Cache::forget("user_{$this->user()->id}.userById");
        Cache::forget("user_{$this->user()->id}.userByIdAndToken");

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}
