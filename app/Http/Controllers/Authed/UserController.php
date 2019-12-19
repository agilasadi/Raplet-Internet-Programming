<?php

namespace raplet\Http\Controllers\Authed;

use raplet\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use raplet\Http\Requests\VerifyPassword;
use raplet\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update_password(VerifyPassword $request)
    {
        $validated = $request->validated();
        User::where('id', Auth::id())->update(['password' => Hash::make($validated[ 'verify_password']), 'verify' => 1]);

        return redirect()->back()->with(['verify-message' => trans('home.user-verified')]);
    }
}
