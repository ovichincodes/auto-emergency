<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service, App\User;

class ServicesController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['title' => 'Available Services'];
        $services = Service::orderBy('created_at', 'desc')->get();
        $users = User::all();
        return view('pages.admin.services.index', $data)->with([
            'services' => $services,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // display the create services page
        $data = ['title' => 'Create Services'];
        $users = User::all();
        return view('pages.admin.services.create', $data)->with(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate form data
        $this->validate($request, [
            'name' => 'required|string|unique:services',
            'main_location' => 'required|string',
            'category' => 'required|numeric',
            'desc' => 'required|string',
        ]);
        // insert services
        $service = new Service();
        $service->name = $request->get('name');
        $service->address = $request->get('main_location');
        $service->category = $request->get('category');
        $service->description = $request->get('desc');

        // save products
        if ($service->save()) {
            return redirect(route('admin.services.index'))->with('success', 'Service Added Successfully!');
        } else {
            return redirect(route('admin.services.create'))->with('error', 'Service could not be added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);
        return $service ? ['isCompleted' => true, 'service' => $service]
                : ['isCompleted' => false, 'msg' => 'Could not find Service!'];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ['title' => 'Edit Services'];
        $service = Service::find($id);
        $users = User::all();
        return view('pages.admin.services.edit', $data)->with([
            'service' => $service,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate form data
        $this->validate($request, [
            'name' => 'required|string',
            'address' => 'required|string',
            'category' => 'required|numeric',
            'desc' => 'required|string',
        ]);
        // get the service to be updated
        $service = Service::find($id);
        $service->name = $request->get('name');
        $service->address = $request->get('address');
        $service->category = $request->get('category');
        $service->description = $request->get('desc');

        // save the updated service
        return $service->save()
            ? redirect(route('admin.services.index'))->with('success', 'Service Updated Successfully!')
            : redirect(route('admin.services.edit', $id))->with('error', 'Service could not be updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete services
        $service = Service::find($id);
        return $service->delete() ? ['isCompleted' => true, 'msg' => 'Service Deleted Successfully!']
                : ['isCompleted' => false, 'msg' => 'Could not delete Service!'];
    }
}