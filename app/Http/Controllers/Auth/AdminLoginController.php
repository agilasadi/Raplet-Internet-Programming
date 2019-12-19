<?php

namespace raplet\Http\Controllers\Auth;

use Illuminate\Http\Request;
use raplet\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:admin');
    }

    public function showLoginForm(){
        return view('auth.admin-login');
    }
    public function login(Request $request){

        // validate form data
        $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required'
        ]);

        //attempt to login
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){

            //success redirect to the needed location
            return redirect()->intended(route('admin.dashboard'));
        }


        //if unsuccesfull redirect back login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
}
