<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\PriceController;
use App\Http\Controllers\admin\OrdersController;
use App\Http\Controllers\admin\OrdershomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PaymentController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Admin Routes List
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.home');

    Route::controller(AdminController::class)->group(function () {

        Route::get('deshboard', 'deshboard')->name('deshboard');
        Route::get('user', 'user')->name('user');
        Route::get('price', 'price')->name('price');
    });

    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('/', 'user')->name('user');
        Route::get('create', 'createuser')->name('user.create');
        Route::post('create', 'createSave');
        Route::get('delete/{id}', 'deleteuser')->name('user.delete');
        Route::get('getAmphures', 'getAmphures')->name('getAmphures');
        Route::get('getDistricts', 'getDistricts')->name('getDistricts');
        Route::get('getZipCode', 'getZipCode')->name('getZipCode');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('create', 'create')->name('create');
        Route::post('create', 'categorySave');
        Route::get('Category/list', 'listcategory')->name('listcategory');
        Route::get('editctr/{id}', 'edit')->name('editctr');
        Route::post('editctr/{id}', 'update');
        Route::get('deletectr/{id}', 'delete')->name('deletectr');
        Route::post('Category/list/{id}', 'updateStatus')->name('categiry');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('pdtcreate', 'pdtcreate')->name('pdtcreate');
        Route::post('pdtcreate', 'productSave');
        Route::get('product', 'listpdt')->name('listpdt');
        Route::get('editpdt/{id}', 'edit')->name('editpdt');
        Route::post('editpdt/{id}', 'update');
        Route::get('deletepdt/{id}', 'delete')->name('deletepdt');
        Route::get('deleteimage/{id}', 'delete_image')->name('delete_image');
        Route::post('editpdt', 'image_sortable')->name('image_sortable');
        Route::get('/products', 'ByGrade');
        Route::post('product/status/{id}', 'updateStatusProduct')->name('updateStatusProduct');
    });


    Route::controller(PriceController::class)->group(function () {
        Route::get('price/create', 'create')->name('create.price');
        Route::post('price/create', 'priceSave')->name('price_save');
        Route::get('price', 'list')->name('price');
        Route::get('price/{id}', 'edit')->name('editprin');
        Route::post('price/{id}', 'update');
        Route::get('pricedelete/{id}', 'delete')->name('deleteprc');
    });

    Route::get('/orders', [OrdersController::class, 'Order'])->name('orders');
    Route::get('/orders/delete/{id}', [OrdersController::class, 'order_delete']);
    Route::get('/orders/detail-sell/{id}', [OrdersController::class, 'order_detailsell'])->name('order_detailsell');
    Route::post('/order/sell-status/{id}', [OrdersController::class, 'updateStatus'])->name('order.updateStatus');
    Route::get('/orders/edit-sell/{id}', [OrdersController::class, 'order_editsell'])->name('order_editsell');
    Route::post('/orders/edit-sell/{id}/updete', [OrdersController::class, 'order_editsell_update'])->name('order_editsell_update');
    Route::get('/orders/showReceipt/{id}', [OrdersController::class, 'showReceipt'])->name('showReceipt');
    


    Route::post('/orders/{id}/status-buy', [OrdersController::class, 'updateStatusbuy'])->name('order.updateStatusbuy');
    Route::get('/orders/delete-buy/{id}', [OrdersController::class, 'order_deletebuy'])->name('delete_buy');
    Route::get('/orders/detail-buy/{id}', [OrdersController::class, 'order_detailbuy'])->name('order_detailbuy');
    Route::get('/orders/detail-buy/edit/{id}', [OrdersController::class, 'order_editbuy'])->name('order_editbuy');
    Route::get('/orders/create-buy/', [OrdersController::class, 'order_create'])->name('order_create');
    Route::get('/orders/create-buy/grade', [OrdersController::class, 'grade'])->name('grade');
    Route::get('/orders/create-buy/price_grade', [OrdersController::class, 'price_grade'])->name('price_grade');

    Route::get('/orders-home', [OrdershomeController::class, 'order_home'])->name('order_home');
    Route::get('/orders-home/create', [OrdershomeController::class, 'order_home_create'])->name('order_home_create');
    Route::post('/orders/create-buy/save', [OrdershomeController::class, 'order_create_save'])->name('order_create_save');
    Route::get('/orders-home/detail/{id}', [OrdershomeController::class, 'order_detail_home'])->name('order_deile_home');
    Route::post('/orders/{id}/status-home', [OrdershomeController::class, 'update_status_buyhome'])->name('update_status_buyhome');
    Route::get('/orders/edit/{id}', [OrdershomeController::class, 'order_home_edit'])->name('order_home_edit');
    Route::post('/orders/edit/{id}/updete', [OrdershomeController::class, 'order_save_edit'])->name('order_save_edit');
    Route::get('/orders-home/create-buy/{id}', [OrdershomeController::class, 'order_e_create'])->name('order_e_create');
    Route::post('/orders/create/save/{id}', [OrdershomeController::class, 'order_e_save'])->name('order_e_save');
    Route::get('/orders-home/delete/{id}', [OrdershomeController::class, 'ordder_home_delete'])->name('ordder_home_delete');
    Route::get('/orders-home/showReceipt/{id}', [OrdershomeController::class, 'showReceipt'])->name('showReceipt');
    
    
    
});

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::post('logut', 'logout')->middleware('auth')->name('logout');
});



Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ProductsController::class, 'home'])->name('home');
Route::get('/list', [ProductsController::class, 'list'])->name('list');
Route::get('/product/{title?}', [ProductsController::class, 'getCategoryName'])->name('categoryName');
Route::get('/products/{id?}', [ProductsController::class, 'getCategoryName'])->name('detail');
Route::get('/produstb', [ProductsController::class, 'getProductPriceByGrade']);



Route::middleware(['user'])->group(function () {
    Route::get('/Home-buy', [HomeController::class, 'userbuyHome'])->name('userbuy.home');
    Route::get('/home-sell', [HomeController::class, 'sellerHome'])->name('seller.home');
});

Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/about', [HomeController::class, 'about']);


Route::get('checkout', [PaymentController::class, 'checkout']);
Route::post('place-order', [PaymentController::class, 'place_order_sell']);
Route::post('place-order-buy', [PaymentController::class, 'place_order_buy']);


Route::get('getAmphures', [PaymentController::class, 'getAmphures']);
Route::get('getDistricts', [PaymentController::class, 'getDistricts']);
Route::get('getZipCode', [PaymentController::class, 'getZipCode']);
Route::post('add-to-cart', [PaymentController::class, 'add_to_cart']);
Route::get('cart', [PaymentController::class, 'cart'])->name('cart');
Route::post('update_cart', [PaymentController::class, 'update_cart']);
Route::get('cart/delete/{id}', [PaymentController::class, 'cart_delete']);


