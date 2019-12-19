<?php

namespace raplet\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use raplet\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use raplet\User;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {// Authetication was successfull
        $success = '1';
        $user = Auth::user();

        return response()->json(['user' => $user, 'success' => $success]);

    }
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        if ($user){// there is no such user in database
            $success = '2';
            return response()->json(['success' => $success]);
        }
        else{// the authentication was unsuccessfull due to password
            $success = '0';
            return response()->json(['success' => $success]);

        }
    }

    // - > Social Registerations < -

    // Facebook Registeration



}
