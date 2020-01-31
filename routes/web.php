<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')
    ->name('home');

Route::get('/product/{product}', 'HomeController@product')
    ->name('product');

Route::get('/products/{category}', 'HomeController@products')
    ->name('products');

Route::get('/categories', 'CategoryController@userView')
    ->name('categories.user-view');

Route::post('/orders/checkout', 'OrderController@create')
    ->name('orders.create');

Route::post('/orders', 'OrderController@store')
    ->name('orders.store');

Route::post('/pay/success', 'OrderController@success')
    ->name('pay.success');

Route::post('/pay/error', 'OrderController@error')
    ->name('pay.error');

Route::match(['get', 'post'], '/pay/{order}', 'OrderController@pay')
    ->name('orders.pay');

Route::get('orders/error/{payment}', 'OrderController@tryAgain')
    ->name('orders.error');

Route::view('orders/success', 'order-success')
    ->name('orders.success');

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('profile', 'UserController@profile')->name('users.profile');
    Route::put('profile/{user}', 'UserController@update')->name('users.profile-update');
});

Route::group(['prefix' => 'admin', 'middleware' => 'is.admin'], function () {
    Route::put('products/stock-update', 'ProductController@stockUpdate')
        ->name('products.stock-update');

    Route::resource('products', 'ProductController')
        ->except(['show']);

    Route::resource('categories', 'CategoryController');

    Route::get('users/{user}/set-vip/{vip}', 'UserController@setVip')
        ->name('users.setvip');

    Route::resource('users', 'UserController')
        ->except(['create', 'store']);

    Route::resource('orders', 'OrderController')
        ->only(['show', 'destroy']);

    Route::get('orders/process/{order}', 'OrderController@processDisplay')->name('orders.process.display');

    Route::post('orders/process/{order}', 'OrderController@process')->name('orders.process');

    Route::get('orders/{user?}', 'OrderController@index')
        ->name('orders.index');
});

Route::get('/contact', 'ContactController@show')
    ->name('contact.show');

Route::view('/terms-and-conditions', 'terms-and-conditions')
    ->name('terms');

Route::post('/contact', 'ContactController@send')
    ->name('contact.send');
