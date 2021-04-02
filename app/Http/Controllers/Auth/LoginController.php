<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Session;
use App\Customer;
use App\Social;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request) {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return response()->json(['status' => 'success', 'message' => '']);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request) {
        return response()->json(['status' => 'error', 'message' => trans('auth.failed')]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $this->guard()->logout();

        /*$request->session()->flush();

        $request->session()->regenerate();*/

        return redirect()->back();
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('customer');
    }

    /**
     * Redirect the user to the Facebook, Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request, $provider) {
        Session::put('beforeLogin', redirect()->back()->getTargetUrl());
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Facebook, Google.
     *
     * @return Response
     */
    public function handleProviderCallback($provider) {
        try {
            $customer_info = Socialite::driver($provider)->user();
        } catch (\Exception $ex) {
            return redirect(Session::pull('beforeLogin', '/'));
        }
        $customer = Customer::where('email', '=', $customer_info->getEmail())->first();

        if (!$customer) {
            $customer = Customer::create([
                'name' => $customer_info->getName(),
                'email' => $customer_info->getEmail(),
                'password' => bcrypt($customer_info->getEmail()),
                'avatar' => $customer_info->getAvatar()
            ]);
        }

        $social = $customer->socials()->where('provider', $provider)->where('social_id', $customer_info->getId())->first();
        if (!$social) {
            $customer->socials()->save(new Social([
                'provider'  => $provider,
                'social_id' => $customer_info->getId()
            ]));
        }

        $this->guard()->login($customer, true);

        if (Session::has('getShareLink')) return redirect()->action('GroupController@getShareLink', Session::pull('getShareLink'));

        return redirect(Session::pull('beforeLogin', '/'));
    }
}
