<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;

class OrdersController extends Controller
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
    
    /*
        @route	GET shopping/orders
        @desc	get all the orders
        @access	Private
    */
    public function index() {
        $data = ['title' => 'All Orders'];
        $orders = auth()->user()->orders()->orderBy('status', 'asc')->get();
        return view('pages.client.orders', $data)->with([
            'orders' => $orders,
        ]);
    }

    /*
        @route	POST shopping/confirmOrder
        @desc	insert a new order into the orders table
        @access	Private
    */
    public function create(Request $request) {
        $this->validate($request, [
            'items' => 'required|string'
        ]);
        
        return auth()->user()->orders()->create([
            'items' => $request['items'],
            'status' => 0
        ]) ? ['isCompleted' => true, 'msg' => 'Order received successfully and awaiting confirmation!']
                : ['isCompleted' => false, 'msg' => 'Could not place this order at this time!'];
    }

    /*
        @route	DELETE users/orders/destroy/{id}
        @desc	delete user order
        @access	Private
    */
    public function destroy($id) {
        return Order::find($id)->delete() 
        ? ['isCompleted' => true, 'msg' => 'Order Deleted Successfully!']
        : ['isCompleted' => false, 'msg' => 'Could not delete this order at this time!'];
    }
}