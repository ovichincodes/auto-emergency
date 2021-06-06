<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;

class ServicesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function getServices($id)
    {
        $services = Service::where(['category' => $id])->get();
        return $services ? ['isCompleted' => true, 'msg' => $services]
                : ['isCompleted' => false, 'msg' => 'Could not get Services!'];
    }
}