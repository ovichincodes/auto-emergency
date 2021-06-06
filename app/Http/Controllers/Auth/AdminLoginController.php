<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['adminLogout']);
    }

    // display the admin login form
    public function showLoginForm() {
        $data = ['title' => 'Admin Login'];
        return view('auth.admin.login', $data);
    }

    // do the actual login
    public function login(Request $request) {
        // validate the data from the login form
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        // atttempt to log in the admin in
        $credentials = ['email' => $request->email, 'password' => $request->password];
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            // return to the intended location is the login successful
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Login Successful!');
        }

        // redirect back to the login form with the form data if the login was unsuccessful
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    // logout admin
    public function adminLogout() {
        Auth::guard('admin')->logout();
        return redirect(route('admin.showLoginForm'));
    }
}