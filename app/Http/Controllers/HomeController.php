<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Service;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $data = ['title' => 'Dashboard'];
        return view('pages.client.dashboard', $data);
    }

    // services page
    public function services()
    {
        $data = ['title' => 'Services'];
        $services = Service::all();
        return view('pages.client.services', $data)->with('services', $services);
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile() {
        $data = ['title' => 'Profile'];
        return view('pages.client.profile', $data);
    }

    // update profile
    public function updateProfile(Request $request) {
        // validate the update form
        $this->validate($request, [
            'fname' => 'required|string|max:191',
            'lname' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|numeric',
            'address' => 'required|string',
        ]);

        // get the current user id
        $id = Auth::id();
        // get the user to update
        $user = User::find($id);
        $user->fname = $request->get('fname');
        $user->lname = $request->get('lname');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');

        return $user->save()
                ? redirect(route('users.profile'))->with('success', 'Profile Updated Successfully!')
                : redirect(route('users.profile'))->with('error', 'Error while updating profile!');
    }

    // update password
    public function updatePassword(Request $request) {
        // validate request
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->get('password'));

        return $user->save()
            ? redirect(route('users.profile'))->with('success', 'Password Updated Successfully!')
            : redirect(route('users.profile'))->with('error', 'Password could not be updated!');
    }
}