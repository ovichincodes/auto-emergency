<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// start of admin routes
Route::get('/admin', 'admin\PagesController@dashboard')->name('admin.dashboard');
Route::get('/admin/users', 'admin\PagesController@users')->name('admin.users');
Route::get('/admin/profile', 'admin\PagesController@profile')->name('admin.profile');
Route::post('/admin/profile/update', 'admin\SettingsController@updateProfile')->name('admin.profile.update');
Route::post('/admin/password/update', 'admin\SettingsController@updatePassword')->name('admin.password.update');
Route::post('/admin/category/create', 'admin\CategoriesController@create')->name('admin.category.create');
Route::resource('admin/products', 'admin\ProductsController', ['as' => 'admin']);
Route::resource('admin/services', 'admin\ServicesController', ['as' => 'admin']);
Route::get('/admin/orders', 'admin\OrdersController@index')->name('admin.orders');
Route::post('/admin/orders/status/update', 'admin\OrdersController@update_status')->name('admin.orders.status.update');
// end of admin routes

// start of client routes
Route::get('/dashboard', 'HomeController@dashboard')->name('users.dashboard');
Route::get('/services', 'HomeController@services')->name('users.services');
Route::get('/shopping/products', 'client\ProductsController@index')->name('shopping.products');
Route::get('/shopping/products/{slug}', 'client\ProductsController@show')->name('shopping.products.single');
Route::get('/shopping/products/categories/{slug}', 'client\ProductsController@categories')->name('shopping.products.categories');
Route::get('/shopping/cart', 'client\ProductsController@cart')->name('shopping.cart');
Route::get('/shopping/checkout', 'client\ProductsController@checkout')->name('shopping.checkout');
Route::post('/shopping/confirmOrder', 'client\OrdersController@create')->name('shopping.confirmOrder');
Route::get('/shopping/orders', 'client\OrdersController@index')->name('shopping.orders');
Route::get('/shopping/products/get/{id}', 'client\ProductsController@getProduct')->name('shopping.products.get');
Route::get('/profile', 'HomeController@profile')->name('users.profile');
Route::post('/profile/update', 'HomeController@updateProfile')->name('users.profile.update');
Route::post('/password/update', 'HomeController@updatePassword')->name('users.password.update');
Route::get('/users/service/getServices/{id}', 'client\ServicesController@getServices')->name('users.services.get');
Route::delete('/users/orders/destroy/{id}', 'client\OrdersController@destroy')->name('users.orders.destroy');
Route::get('/users/logout', 'auth\LoginController@userlogout')->name('users.logout');
// end of client routes
Auth::routes();
Route::get('/register/mechanic', 'MechanicController@showMechanicForm')->name('register.mechanicForm');
Route::post('/register/mechanic', 'MechanicController@registerMechanic')->name('register.mechanic');

Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.showLoginForm');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login');
Route::get('/admin/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');