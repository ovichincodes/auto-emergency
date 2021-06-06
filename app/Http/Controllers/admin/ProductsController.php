<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Product, App\Category, App\User;

class ProductsController extends Controller
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
        // display the products page with the table of products
        $data = ['title' => 'Available Products'];
        $products = Product::orderBy('created_at', 'desc')->get();
        $users = User::all();
        return view('pages.admin.products.index', $data)->with([
            'products' => $products,
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
        // display the create products page
        $data = ['title' => 'Create Products'];
        $categories = Category::orderBy('name', 'asc')->get();
        $users = User::all();
        return view('pages.admin.products.create', $data)->with([
            'categories' => $categories,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:products',
            'p_qty' => 'required|numeric',
            'p_price' => 'required|numeric',
            'p_category' => 'required|string',
            'p_desc' => 'required|string',
            'p_image' => 'required|file|mimetypes:image/png,image/jpg,image/jpeg,image/bmp',
        ]);

        // move image to storage
        if ($request->hasFile('p_image')) {
            // get file name with extension
            $filenamewithExt = $request->file('p_image')->getClientOriginalName();
            //get just file name
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
            // get just the extension
            $extension = $request->file('p_image')->getClientOriginalExtension();
            // file name to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;
            //upload file
            $path = $request->file('p_image')->storeAs('public/productImages', $filenametostore);
            
            // insert products
            $product = new Product();
            $product->name = $request->get('name');
            $product->slug = Str::slug($request->get('name'), '-');
            $product->category_id = $request->get('p_category');
            $product->price = $request->get('p_price');
            $product->quantity = $request->get('p_qty');
            $product->description = $request->get('p_desc');
            $product->image = $filenametostore;

            // save products
            if ($product->save()) {
                return redirect(route('admin.products.index'))->with('success', 'Product Added Successfully!');
            } else {
                return redirect(route('admin.products.create'))->with('error', 'Product could not be added!');
            }
        } else {
            return redirect(route('admin.products.create'))->with('error', 'Image file is required!');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ['title' => 'Edit Products'];
        $categories = Category::orderBy('name', 'asc')->get();
        $product = Product::where(['slug' => $id])->first();
        $users = User::all();
        return view('pages.admin.products.edit', $data)->with([
            'categories' => $categories,
            'product' => $product,
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
        $this->validate($request, [
            'p_name' => 'required|string',
            'p_qty' => 'required|numeric',
            'p_price' => 'required|numeric',
            'p_category' => 'required|string',
            'p_desc' => 'required|string',
            'p_image' => 'file|mimetypes:image/png,image/jpg,image/jpeg,image/bmp',
        ]);

        // get the product to be updated
        $product = Product::find($id);

        // if the request came with in image
        // means the image will be updated as well
        if ($request->hasFile('p_image')) {
            // delete the previous image
            Storage::delete('public/productImages/' . $product->image);
            // get file name with extension
            $filenamewithExt = $request->file('p_image')->getClientOriginalName();
            //get just file name
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
            // get just the extension
            $extension = $request->file('p_image')->getClientOriginalExtension();
            // file name to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;
            //upload file
            $path = $request->file('p_image')->storeAs('public/productImages', $filenametostore);
        }
        $product->name = $request->get('p_name');
        $product->slug = Str::slug($request->get('p_name'), '-');
        $product->category_id = $request->get('p_category');
        $product->price = $request->get('p_price');
        $product->quantity = $request->get('p_qty');
        $product->description = $request->get('p_desc');
        $product->image = $request->hasFile('p_image') ? $filenametostore : $product->image;

        // save products
        return $product->save()
            ? redirect(route('admin.products.index'))->with('success', 'Product Updated Successfully!')
            : redirect(route('admin.products.edit', $id))->with('error', 'Product could not be updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete product
        $product = Product::find($id);
        $deleted = false;
        // delete the product image from storage
        if (Storage::delete('public/productImages/' . $product->image)) {
            $deleted = $product->delete();
        }
        // delete product from db
        return $deleted ? ['isCompleted' => true, 'msg' => 'Product Deleted Successfully!']
                : ['isCompleted' => false, 'msg' => 'Could not delete Product!'];
    }
}