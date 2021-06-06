<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order, App\User;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /*
        @route	GET shopping/orders
        @desc	get all the orders
        @access	Private
    */
    public function index() {
        $data = ['title' => 'All Orders'];
        $orders = Order::orderBy('status', 'asc')->get();
        $users = User::orderBy('fname', 'asc')->get();
        return view('pages.admin.orders', $data)->with([
            'orders' => $orders,
            'users' => $users
        ]);
    }

    /*
        @route	POST admin/orders/status/update
        @desc	update the status of user's order
        @access	Private
    */
    public function update_status(Request $request) {
        $order = Order::find($request["oid"]);
        $order->status = (int)$request['status'];
        return $order->save() ? ['isCompleted' => true, 'msg' => 'Order Status Updated Successfully!']
            : ['isCompleted' => false, 'msg' => 'Could not update Order Status!'];
    }
}