<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User, App\Service, App\Product;

class PagesController extends Controller
{
    private $users;

    public function __construct() {
        $this->middleware('auth:admin');
        $this->users = User::orderBy('fname', 'asc')->get();
    }

    // dashboard function
    // return the dashboard page --- show preview of the activities in the site
    public function dashboard() {
        $data = ['title' => 'Dashboard'];
        return view('pages.admin.dashboard', $data)->with([
            'users' => $this->users,
            'num_services' => Service::count(),
            'num_products' => Product::count(),
        ]);
    }

    // users function
    // return the users page --- displays all the users of the application
    public function users() {
        $data = ['title' => 'Available Users'];
        return view('pages.admin.users', $data)->with([
            'users' => $this->users
        ]);
    }

    // profile function
    // returns the profile page --- shows the profile of the admin
    public function profile() {
        $data = ['title' => 'Profile'];
        return view('pages.admin.profile', $data)->with([
            'users' => $this->users
        ]);
    }
}