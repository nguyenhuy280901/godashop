<?php

use Illuminate\Support\Facades\Route;
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

/* --------------------------- Route site --------------------------- */
// Route home
Route::namespace('App\Http\Controllers\Site')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    // Route auth
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/register', 'AuthController@register')->name('register');
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::post('/forgot-password', 'AuthController@forgotPassword')->name('forgot');
    Route::get('/reset/{token}/{email}', 'AuthController@showResetForm')->name('reset-form');
    Route::get('/verify/{token}', 'AuthController@verify')->name('verify');

    // Route login social
    Route::get('/login-social/{social}', 'SocialAuthController@redirect')->name('login-social');
    Route::get('/login-social/callback/{social}', 'SocialAuthController@callback')->name('login-social-callback');

    // Route product
    Route::resource('/product', 'ProductController', [
        'only' => ['index', 'show']
    ]);
    Route::get('/product/search/{pattern}', 'ProductController@ajaxSearch')->name('product.ajaxSearch');
    Route::post('/product/search', 'ProductController@search')->name('product.search');

    // Route policy
    Route::get('/return-policy', 'PolicyController@return')->name('return-policy');
    Route::get('/delivery-policy', 'PolicyController@delivery')->name('delivery-policy');
    Route::get('/payment-policy', 'PolicyController@payment')->name('payment-policy');

    // Route contact
    Route::get('/contact', 'ContactController@index')->name('contact.index');
    Route::post('/contact', 'ContactController@sendMail')->name('contact.sendmail');

    // Route address
    Route::prefix('address')->group(function () {
        Route::get('/{province}/districts', 'AddressController@getDistricts');
        Route::get('/{district}/wards', 'AddressController@getWards');
        Route::get('/shippingfee/{province}', 'AddressController@getShippingFee');
    });

    // Route cart
    Route::prefix('cart')->group(function () {
        Route::get('/', 'CartController@get')->name('cart.get');
        Route::get('/add/{product}/{quanlity}', 'CartController@add')->name('cart.add');
        Route::get('/update/{row}/{quanlity}', 'CartController@update')->name('cart.update');
        Route::get('/delete/{row}', 'CartController@delete')->name('cart.delete');
        Route::get('/discount', 'CartController@discount')->name('cart.discount');
        Route::get('/voucher', 'CartController@voucher')->name('cart.voucher');
    });

    // Route payment
    Route::prefix('order')->group(function () {
        Route::get('/checkout', 'PaymentController@checkout')->name('order.checkout');
        Route::post('/store', 'PaymentController@store')->name('order.store');
        Route::get('/store/success', 'PaymentController@storeSuccess')->name('order.store.success');

        // Route order
        Route::get('/{order}', 'OrderController@show')->name('order.show');
    });

    Route::middleware(['auth'])->group(function () {
        // Route customer
        Route::prefix('customer')->group(function () {
            Route::get('/info', 'CustomerController@info')->name('customer.info.show');
            Route::post('/info', 'CustomerController@update')->name('customer.info.update');
            Route::get('/shipping', 'CustomerController@shipping')->name('customer.shipping.show');
            Route::post('/shipping', 'CustomerController@updateShipping')->name('customer.shipping.update');
            Route::get('/order/list', 'CustomerController@listOrder')->name('customer.order.list');
            Route::get('/order/{order}', 'CustomerController@listOrder')->name('customer.order.show');
        });

        // Route Comment
        Route::get('/comment/post', 'CommentController@post')->name('comment.post');
    });
});

/* -------------------------- Route admin -------------------------- */
Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function (){
    Route::middleware(['authAdmin:admin'])->group(function () {
        Route::get('/', "DashboardController@index")->name("dashboard");

        //Order
        Route::get('/order/confirm/{order}', "OrderController@confirm")->name("admin.order.confirm");
        Route::resource('/order', 'OrderController', [
            'names' => [
                'index' => 'admin.order.index',
                'create' => 'admin.order.create',
                'show' => 'admin.order.show',
                'store' => 'admin.order.store',
                'edit' => 'admin.order.edit',
                'update' => 'admin.order.update',
                'destroy' => 'admin.order.destroy',
            ]
        ]);

        //Product
        Route::get('/product/search/{pattern}', "ProductController@search")->name("admin.product.search");
        Route::get('/product/find/{barcode}', "ProductController@find")->name("admin.product.find");
        Route::resource('/product', 'ProductController', [
            'names' => [
                'index' => 'admin.product.index',
                'create' => 'admin.product.create',
                'show' => 'admin.product.show',
                'store' => 'admin.product.store',
                'edit' => 'admin.product.edit',
                'update' => 'admin.product.update',
                'destroy' => 'admin.product.destroy',
            ]
        ]);
        
        // Category
        Route::resource('/category', 'CategoryController', [
            'names' => [
                'index' => 'admin.category.index',
                'create' => 'admin.category.create',
                'store' => 'admin.category.store',
                'edit' => 'admin.category.edit',
                'update' => 'admin.category.update',
                'destroy' => 'admin.category.destroy',
            ],
            'except' => [
                'show'
            ],
        ]);

        // Customer
        Route::get('/customer/address/{customer}', 'CustomerController@getAddress');
    });

    Route::get('login', "LoginController@index")->name("admin.login.form");
    Route::post('login', "LoginController@login")->name("admin.login");
    Route::post('logout', "LoginController@logout")->name("admin.logout");
});