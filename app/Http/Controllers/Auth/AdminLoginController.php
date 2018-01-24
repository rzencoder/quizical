<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login()
    {
        //Validate form data
        $request = request();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $credentials = ['email' => $request->email, 'password'=> $request->password];
        //Attempt to login user
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
        //if successful redirect to chosen route
            return redirect()->intended(route('admin.dashboard'));
        }  
        //unsuccessful redirect back
        return redirect()->back()->with('error', 'Error logging in')->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

}
