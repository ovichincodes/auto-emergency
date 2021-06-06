<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Category;

class CategoriesController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }
    
    // create a new products category
    public function create(Request $request) {
        // validate the request
        $this->validate($request, [
            'name' => 'required|unique:categories|string|max:100',
        ]);
        // insert new category
        $cate = new Category();
        $cate->name = $request->get('name');
        $cate->slug = Str::slug($request->get('name'), '-');
        return 
            $cate->save() ? 
                redirect(route('admin.products.create'))->with('success', 'Category Created Successfully!')
                : redirect(route('admin.products.create'))->with('error', 'Category could not be created!');
    }
}