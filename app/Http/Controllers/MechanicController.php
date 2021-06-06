<?php

namespace App\Http\Controllers;
use App\Service;

use Illuminate\Http\Request;

class MechanicController extends Controller
{
    // show the mechanic registration form
    public function showMechanicForm() {
        $data = ['title' => 'Mechanic Registration'];
        return view('pages.mechanic.register', $data);
    }

    // add the mechanic service
    public function registerMechanic(Request $request) {
        // validate form data
        $this->validate($request, [
            'name' => 'required|string|unique:services',
            'main_location' => 'required|string',
            'phone' => 'required|string',
        ]);
        // insert services
        $service = new Service();
        $service->name = $request->get('name');
        $service->address = $request->get('main_location');
        $service->category = 3;
        $service->description = $request->get('phone');

        // save products
        if ($service->save()) {
            return redirect(route('register.mechanicForm'))->with('success', 'Mechanic Registed Successfully!');
        } else {
            return redirect(route('register.mechanicForm'))->with('error', 'Mechanic could not be registered!');
        }
    }
}