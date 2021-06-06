<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product, App\Category;

class ProductsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // display the products page to the client
    public function index() {
        $data = ['title' => 'Available Products'];
        $products = Product::orderBy('created_at', 'desc')->paginate(8);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('pages.client.products.index', $data)->with([
            'products' => $products,
            'categories' => $categories
        ]);
    }

    // display the details of a single product
    public function show($slug) {
        $categories = Category::orderBy('name', 'asc')->get();
        $item = Product::where(['slug' => $slug])->first();
        $related_products = Product::where('category_id', $item->category_id)
                            ->orderBy('created_at', 'desc')->paginate(3);
        return $item ? view('pages.client.products.show', ['title' => $item->name])->with([
            'item' => $item,
            'related_products' => $related_products,
            'categories' => $categories
        ]) : view('404', ['title' => 'Item not Found!']);
    }

    // display the products in a single category
    public function categories($slug) {
        $categories = Category::orderBy('name', 'asc')->get();
        $category = Category::where('slug', $slug)->first();
        return $category ? view('pages.client.products.category',
            ['title' => $category->name . ' Category'])->with([
            'products' => $category->products,
            'categories' => $categories
        ]) : view('404', ['title' => 'Category not Found!']);
    }

    // get a product to add to cart
    public function getProduct($id) {
        $product = Product::find($id);
        return $product ? ['isCompleted' => true, 'product' => $product]
                : ['isCompleted' => false, 'msg' => 'Could not find Product!'];
    }

    // display the cart in a full page
    public function cart() {
        $data = ['title' => 'Shopping Cart'];
        return view('pages.client.products.cart', $data);
    }

    // load the checkout page
    public function checkout() {
        $data = ['title' => 'Checkout'];
        return view('pages.client.products.checkout', $data);
    }
}