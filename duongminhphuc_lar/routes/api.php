<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductSaleController;
use App\Http\Controllers\Api\ProductStoreController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderDetailController;
use App\Http\Controllers\Api\CarController as Cart;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for Backend Management
Route::prefix('banner')->group(function(){
    Route::get('/',[BannerController::class, 'index']);
    Route::get('/trash',[BannerController::class, 'trash']);
    Route::get('/show/{id}',[BannerController::class, 'show']);
    Route::post('/store',[BannerController::class, 'store']);
    Route::post('/update/{id}',[BannerController::class, 'update']);
    Route::get('/status/{id}',[BannerController::class, 'status']);
    Route::get('/delete/{id}',[BannerController::class, 'delete']);
    Route::get('/restore/{id}',[BannerController::class, 'restore']);
    Route::delete('/destroy/{id}',[BannerController::class, 'destroy']);
});

Route::prefix('brand')->group(function(){
    Route::get('/',[BrandController::class, 'index']);
    Route::get('/trash',[BrandController::class, 'trash']);
    Route::get('/show/{id}',[BrandController::class, 'show']);
    Route::post('/store',[BrandController::class, 'store']);
    Route::post('/update/{id}',[BrandController::class, 'update']);
    Route::get('/status/{id}',[BrandController::class, 'status']);
    Route::get('/delete/{id}',[BrandController::class, 'delete']);
    Route::get('/restore/{id}',[BrandController::class, 'restore']);
    Route::delete('/destroy/{id}',[BrandController::class, 'destroy']);
});

Route::prefix('category')->group(function(){
    Route::get('/',[CategoryController::class, 'index']);
    Route::get('/trash',[CategoryController::class, 'trash']);
    Route::get('/show/{id}',[CategoryController::class, 'show']);
    Route::post('/store',[CategoryController::class, 'store']);
    Route::post('/update/{id}',[CategoryController::class, 'update']);
    Route::get('/status/{id}',[CategoryController::class, 'status']);
    Route::get('/delete/{id}',[CategoryController::class, 'delete']);
    Route::get('/restore/{id}',[CategoryController::class, 'restore']);
    Route::delete('/destroy/{id}',[CategoryController::class, 'destroy']);
});

Route::prefix('menu')->group(function(){
    Route::get('/',[MenuController::class, 'index']);
    Route::get('/trash',[MenuController::class, 'trash']);
    Route::get('/show/{id}',[MenuController::class, 'show']);
    Route::post('/store',[MenuController::class, 'store']);
    Route::post('/update/{id}',[MenuController::class, 'update']);
    Route::get('/status/{id}',[MenuController::class, 'status']);
    Route::get('/delete/{id}',[MenuController::class, 'delete']);
    Route::get('/restore/{id}',[MenuController::class, 'restore']);
    Route::delete('/destroy/{id}',[MenuController::class, 'destroy']);
});

Route::prefix('contact')->group(function(){
    Route::get('/',[ContactController::class, 'index']);
    Route::get('/trash',[ContactController::class, 'trash']);
    Route::post('/store',[ContactController::class, 'store']);
    Route::get('/show/{id}',[ContactController::class, 'show']);
    Route::post('/reply/{id}',[ContactController::class, 'reply']);
    Route::get('/status/{id}',[ContactController::class, 'status']);
    Route::get('/delete/{id}',[ContactController::class, 'delete']);
    Route::get('/restore/{id}',[ContactController::class, 'restore']);
    Route::delete('/destroy/{id}',[ContactController::class, 'destroy']);
});

Route::prefix('post')->group(function(){
    Route::get('/',[PostController::class, 'index']);
    Route::get('/trash',[PostController::class, 'trash']);
    Route::get('/topic/{slug}',[PostController::class, 'topic']);
    Route::get('/show/{id}',[PostController::class, 'show']);
    Route::post('/store',[PostController::class, 'store']);
    Route::post('/update/{id}',[PostController::class, 'update']);
    Route::get('/status/{id}',[PostController::class, 'status']);
    Route::get('/detail/{slug}',[PostController::class, 'detail']);
    Route::get('/delete/{id}',[PostController::class, 'delete']);
    Route::get('/restore/{id}',[PostController::class, 'restore']);
    Route::delete('/destroy/{id}',[PostController::class, 'destroy']);
});

Route::prefix('topic')->group(function(){
    Route::get('/',[TopicController::class, 'index']);

    Route::get('/trash',[TopicController::class, 'trash']);
    Route::get('/show/{id}',[TopicController::class, 'show']);
    Route::post('/store',[TopicController::class, 'store']);
    Route::post('/update/{id}',[TopicController::class, 'update']);
    Route::get('/status/{id}',[TopicController::class, 'status']);
    Route::get('/delete/{id}',[TopicController::class, 'delete']);
    Route::get('/restore/{id}',[TopicController::class, 'restore']);
    Route::delete('/destroy/{id}',[TopicController::class, 'destroy']);
});

Route::prefix('user')->group(function(){
    Route::get('/',[UserController::class, 'index']);
    Route::get('/trash',[UserController::class, 'trash']);
    Route::get('/show/{id}',[UserController::class, 'show']);
    Route::post('/store',[UserController::class, 'store']);
    Route::post('/update/{id}',[UserController::class, 'update']);
    Route::get('/status/{id}',[UserController::class, 'status']);
    Route::get('/delete/{id}',[UserController::class, 'delete']);
    Route::get('/restore/{id}',[UserController::class, 'restore']);
    Route::delete('/destroy/{id}',[UserController::class, 'destroy']);
});

Route::prefix('cart')->group(function(){
    Route::get('/',[Cart::class, 'index']);
    Route::post('/add/{id}',[Cart::class, 'addcart']);
    Route::post('/update/{id}',[Cart::class, 'updatecart']);
    Route::post('/delete/{id}',[Cart::class, 'delcart']);
});

Route::prefix('product')->group(function(){
    Route::get('/detail/{slug}',[ProductController::class, 'detail']);
    Route::get('/',[ProductController::class, 'index']);
    Route::get('/new',[ProductController::class, 'new']);
    Route::get('/sale',[ProductController::class, 'sale']);
    Route::get('/trash',[ProductController::class, 'trash']);
    Route::get('/search/{keyword?}',[ProductController::class, 'searchNameProduct']);
    Route::get('/category/{slug}',[ProductController::class, 'category']);
    Route::get('/show/{id}',[ProductController::class, 'show']);
    Route::get('/brand/{slug}',[ProductController::class, 'brand']);
    Route::post('/store',[ProductController::class, 'store']);
    Route::post('/update/{id}',[ProductController::class, 'update']);
    Route::get('/status/{id}',[ProductController::class, 'status']);
    Route::get('/delete/{id}',[ProductController::class, 'delete']);
    Route::get('/restore/{id}',[ProductController::class, 'restore']);
    Route::delete('/destroy/{id}',[ProductController::class, 'destroy']);
});

// Route::prefix('productsale')->group(function(){
//     Route::get('/',[ProductSaleController::class, 'index']);
//     Route::get('/trash',[ProductSaleController::class, 'trash']);
//     Route::get('/show/{id}',[ProductSaleController::class, 'show']);
//     Route::post('/store',[ProductSaleController::class, 'store']);
//     Route::post('/update/{id}',[ProductSaleController::class, 'update']);
//     Route::get('/status/{id}',[ProductSaleController::class, 'status']);
//     Route::get('/delete/{id}',[ProductSaleController::class, 'delete']);
//     Route::get('/restore/{id}',[ProductSaleController::class, 'restore']);
//     Route::delete('/destroy/{id}',[ProductSaleController::class, 'destroy']);
// });

// Route::prefix('productstore')->group(function(){
//     Route::get('/',[ProductStoreController::class, 'index']);
//     Route::get('/trash',[ProductStoreController::class, 'trash']);
//     Route::get('/show/{id}',[ProductStoreController::class, 'show']);
//     Route::post('/store',[ProductStoreController::class, 'store']);
//     Route::post('/update/{id}',[ProductStoreController::class, 'update']);
//     Route::get('/status/{id}',[ProductStoreController::class, 'status']);
//     Route::get('/delete/{id}',[ProductStoreController::class, 'delete']);
//     Route::get('/restore/{id}',[ProductStoreController::class, 'restore']);
//     Route::delete('/destroy/{id}',[ProductStoreController::class, 'destroy']);
// });

Route::prefix('order')->group(function(){
    Route::get('/',[OrderController::class, 'index']);
    Route::get('/trash',[OrderController::class, 'trash']);
    Route::get('/user/{user_id}',[OrderController::class, 'ordersByUser']);
    Route::post('/store',[OrderController::class, 'store']);
    Route::get('/show/{id}',[OrderController::class, 'show']);
    Route::post('/update/{id}',[OrderController::class, 'update']);
    Route::get('/status/{id}',[OrderController::class, 'status']);
    Route::delete('/destroy/{id}',[OrderController::class, 'destroy']);
});

Route::prefix('user')->group(function(){
    Route::post('/register', [UserController::class, 'doRegister']);
    Route::post('/login', [UserController::class, 'doLogin']);
});
// Route::prefix('orderdetail')->group(function(){
//     Route::get('/', [OrderDetailController::class, 'index']);
//     Route::get('/trash', [OrderDetailController::class, 'trash']);
//     Route::post('/store', [OrderDetailController::class, 'store']);
//     Route::get('/show/{id}', [OrderDetailController::class, 'show']);
// });
