<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Auth;

class SettingsController extends Controller
{
    // constructor to init middleware
    public function __construct() {
        $this->middleware('auth:admin');
    }

    // update admin profile
    public function updateProfile(Request $request) {
        // validate the update form
        $this->validate($request, [
            'fname' => 'required|string|max:191',
            'lname' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|numeric',
        ]);
        // get the admin to update
        $admin = Admin::find(Auth::id());
        $admin->fname = $request->get('fname');
        $admin->lname = $request->get('lname');
        $admin->email = $request->get('email');
        $admin->phone = $request->get('phone');

        return $admin->save()
                ? redirect(route('admin.profile'))->with('success', 'Profile Updated Successfully!')
                : redirect(route('admin.profile'))->with('error', 'Error while updating profile!');
    }

    // update admin password
    public function updatePassword(Request $request) {
        // validate request
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed',
        ]);
        $admin = Admin::find(Auth::id());
        $admin->password = Hash::make($request->get('password'));

        return $admin->save()
            ? redirect(route('admin.profile'))->with('success', 'Password Updated Successfully!')
            : redirect(route('admin.profile'))->with('error', 'Password could not be updated!');
    }
}