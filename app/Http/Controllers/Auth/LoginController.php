<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        $from    = $_SERVER['HTTP_REFERER'];
        $fromArr = explode('/', $from);
        if (in_array('frontend', $fromArr)) {
            return back();
        }
    }

    protected function loggedOut(Request $request)
    {
        $from    = $_SERVER['HTTP_REFERER'];
        $fromArr = explode('/', $from);
        if (in_array('frontend', $fromArr)) {
            return back();
        }
    }
}
