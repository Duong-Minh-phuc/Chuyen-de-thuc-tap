<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\BannerController as AdminBannerController;
use App\Http\Controllers\backend\BrandController as AdminBrandController;
use App\Http\Controllers\backend\CategoryController as AdminCategoryController;
use App\Http\Controllers\backend\ProductController as AdminProductController;
use App\Http\Controllers\backend\ContactController as AdminContactController;
use App\Http\Controllers\backend\MenuController as AdminMenuController;
use App\Http\Controllers\backend\OrderController as AdminOrderController;
use App\Http\Controllers\backend\PostController as AdminPostController;
use App\Http\Controllers\backend\TopicController as AdminTopicController;
use App\Http\Controllers\backend\UserController as AdminUserController;
use App\Http\Controllers\Backend\AuthController;

// Admin Auth Routes
Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'dologin'])->name('admin.dologin');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Redirect root to admin login
Route::get('/', function() {
    return redirect()->route('admin.login');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'auth.check'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Banner Routes
    Route::prefix('banner')->group(function () {
        Route::get('/', [AdminBannerController::class, 'index'])->name('admin.banner.index');
        Route::get('/create', [AdminBannerController::class, 'create'])->name('admin.banner.create');
        Route::post('/store', [AdminBannerController::class, 'store'])->name('admin.banner.store');
        Route::get('/trash', [AdminBannerController::class, 'trash'])->name('admin.banner.trash');
        Route::get('/{banner}/edit', [AdminBannerController::class, 'edit'])->name('admin.banner.edit');
        Route::put('/{banner}/update', [AdminBannerController::class, 'update'])->name('admin.banner.update');
        Route::get('/{banner}/show', [AdminBannerController::class, 'show'])->name('admin.banner.show');
        Route::get('/{banner}/status', [AdminBannerController::class, 'status'])->name('admin.banner.status');
        Route::get('/{banner}/delete', [AdminBannerController::class, 'delete'])->name('admin.banner.delete');
        Route::get('/{banner}/restore', [AdminBannerController::class, 'restore'])->name('admin.banner.restore');
        Route::delete('/{banner}/destroy', [AdminBannerController::class, 'destroy'])->name('admin.banner.destroy');
    });

    // Brand Routes
    Route::prefix('brand')->group(function () {
        Route::get('/', [AdminBrandController::class, 'index'])->name('admin.brand.index');
        Route::get('/create', [AdminBrandController::class, 'create'])->name('admin.brand.create');
        Route::post('/store', [AdminBrandController::class, 'store'])->name('admin.brand.store');
        Route::get('/trash', [AdminBrandController::class, 'trash'])->name('admin.brand.trash');
        Route::get('/{brand}/edit', [AdminBrandController::class, 'edit'])->name('admin.brand.edit');
        Route::put('/{brand}/update', [AdminBrandController::class, 'update'])->name('admin.brand.update');
        Route::get('/{brand}/show', [AdminBrandController::class, 'show'])->name('admin.brand.show');
        Route::get('/{brand}/status', [AdminBrandController::class, 'status'])->name('admin.brand.status');
        Route::get('/{brand}/delete', [AdminBrandController::class, 'delete'])->name('admin.brand.delete');
        Route::get('/{brand}/restore', [AdminBrandController::class, 'restore'])->name('admin.brand.restore');
        Route::delete('/{brand}/destroy', [AdminBrandController::class, 'destroy'])->name('admin.brand.destroy');
    });

    // Category Routes
    Route::prefix('category')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/create', [AdminCategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/store', [AdminCategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/trash', [AdminCategoryController::class, 'trash'])->name('admin.category.trash');
        Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/{category}/update', [AdminCategoryController::class, 'update'])->name('admin.category.update');
        Route::get('/{category}/show', [AdminCategoryController::class, 'show'])->name('admin.category.show');
        Route::get('/{category}/status', [AdminCategoryController::class, 'status'])->name('admin.category.status');
        Route::get('/{category}/delete', [AdminCategoryController::class, 'delete'])->name('admin.category.delete');
        Route::get('/{category}/restore', [AdminCategoryController::class, 'restore'])->name('admin.category.restore');
        Route::delete('/{category}/destroy', [AdminCategoryController::class, 'destroy'])->name('admin.category.destroy');
    });

    // Product Routes
    Route::prefix('product')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin.product.create');
        Route::post('/store', [AdminProductController::class, 'store'])->name('admin.product.store');
        Route::get('/trash', [AdminProductController::class, 'trash'])->name('admin.product.trash');
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/{product}/update', [AdminProductController::class, 'update'])->name('admin.product.update');
        Route::get('/{product}/show', [AdminProductController::class, 'show'])->name('admin.product.show');
        Route::get('/{product}/status', [AdminProductController::class, 'status'])->name('admin.product.status');
        Route::get('/{product}/delete', [AdminProductController::class, 'delete'])->name('admin.product.delete');
        Route::get('/{product}/restore', [AdminProductController::class, 'restore'])->name('admin.product.restore');
        Route::delete('/{product}/destroy', [AdminProductController::class, 'destroy'])->name('admin.product.destroy');
    });

    // Menu Routes
    Route::prefix('menu')->group(function () {
        Route::get('/', [AdminMenuController::class, 'index'])->name('admin.menu.index');
        Route::get('/create', [AdminMenuController::class, 'create'])->name('admin.menu.create');
        Route::post('/store', [AdminMenuController::class, 'store'])->name('admin.menu.store');
        Route::get('/trash', [AdminMenuController::class, 'trash'])->name('admin.menu.trash');
        Route::get('/{menu}/edit', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
        Route::put('/{menu}/update', [AdminMenuController::class, 'update'])->name('admin.menu.update');
        Route::get('/{menu}/show', [AdminMenuController::class, 'show'])->name('admin.menu.show');
        Route::get('/{menu}/status', [AdminMenuController::class, 'status'])->name('admin.menu.status');
        Route::get('/{menu}/delete', [AdminMenuController::class, 'delete'])->name('admin.menu.delete');
        Route::get('/{menu}/restore', [AdminMenuController::class, 'restore'])->name('admin.menu.restore');
        Route::delete('/{menu}/destroy', [AdminMenuController::class, 'destroy'])->name('admin.menu.destroy');
    });

    // Order Routes
    Route::prefix('order')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.order.index');
        Route::get('/update-status/{order}', [AdminOrderController::class, 'updateStatus'])->name('admin.order.update-status');
        Route::post('/store', [AdminOrderController::class, 'store'])->name('admin.order.store');
        Route::get('/trash', [AdminOrderController::class, 'trash'])->name('admin.order.trash');
        Route::get('/{order}/edit', [AdminOrderController::class, 'edit'])->name('admin.order.edit');
        Route::put('/{order}/update', [AdminOrderController::class, 'update'])->name('admin.order.update');
        Route::get('/{order}/show', [AdminOrderController::class, 'show'])->name('admin.order.show');
        Route::get('/{order}/status', [AdminOrderController::class, 'status'])->name('admin.order.status');
        Route::get('/{order}/delete', [AdminOrderController::class, 'delete'])->name('admin.order.delete');
        Route::get('/{order}/restore', [AdminOrderController::class, 'restore'])->name('admin.order.restore');
        Route::delete('/{order}/destroy', [AdminOrderController::class, 'destroy'])->name('admin.order.destroy');
    });

    // Post Routes
    Route::prefix('post')->group(function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('admin.post.index');
        Route::get('/create', [AdminPostController::class, 'create'])->name('admin.post.create');
        Route::post('/store', [AdminPostController::class, 'store'])->name('admin.post.store');
        Route::get('/trash', [AdminPostController::class, 'trash'])->name('admin.post.trash');
        Route::get('/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.post.edit');
        Route::put('/{post}/update', [AdminPostController::class, 'update'])->name('admin.post.update');
        Route::get('/{post}/show', [AdminPostController::class, 'show'])->name('admin.post.show');
        Route::get('/{post}/status', [AdminPostController::class, 'status'])->name('admin.post.status');
        Route::get('/{post}/delete', [AdminPostController::class, 'delete'])->name('admin.post.delete');
        Route::get('/{post}/restore', [AdminPostController::class, 'restore'])->name('admin.post.restore');
        Route::delete('/{post}/destroy', [AdminPostController::class, 'destroy'])->name('admin.post.destroy');
    });

    // Topic Routes
    Route::prefix('topic')->group(function () {
        Route::get('/', [AdminTopicController::class, 'index'])->name('admin.topic.index');
        Route::get('/create', [AdminTopicController::class, 'create'])->name('admin.topic.create');
        Route::post('/store', [AdminTopicController::class, 'store'])->name('admin.topic.store');
        Route::get('/trash', [AdminTopicController::class, 'trash'])->name('admin.topic.trash');
        Route::get('/{topic}/edit', [AdminTopicController::class, 'edit'])->name('admin.topic.edit');
        Route::put('/{topic}/update', [AdminTopicController::class, 'update'])->name('admin.topic.update');
        Route::get('/{topic}/show', [AdminTopicController::class, 'show'])->name('admin.topic.show');
        Route::get('/{topic}/status', [AdminTopicController::class, 'status'])->name('admin.topic.status');
        Route::get('/{topic}/delete', [AdminTopicController::class, 'delete'])->name('admin.topic.delete');
        Route::get('/{topic}/restore', [AdminTopicController::class, 'restore'])->name('admin.topic.restore');
        Route::delete('/{topic}/destroy', [AdminTopicController::class, 'destroy'])->name('admin.topic.destroy');
    });

    // User Routes
    Route::prefix('user')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.user.index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin.user.create');
        Route::post('/store', [AdminUserController::class, 'store'])->name('admin.user.store');
        Route::get('/trash', [AdminUserController::class, 'trash'])->name('admin.user.trash');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/{user}/update', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::get('/{user}/show', [AdminUserController::class, 'show'])->name('admin.user.show');
        Route::get('/{user}/status', [AdminUserController::class, 'status'])->name('admin.user.status');
        Route::get('/{user}/delete', [AdminUserController::class, 'delete'])->name('admin.user.delete');
        Route::get('/{user}/restore', [AdminUserController::class, 'restore'])->name('admin.user.restore');
        Route::delete('/{user}/destroy', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');
    });

    // Contact Routes
    Route::prefix('contact')->group(function () {
        Route::get('/', [AdminContactController::class, 'index'])->name('admin.contact.index');
        Route::get('/create', [AdminContactController::class, 'create'])->name('admin.contact.create');
        Route::post('/store', [AdminContactController::class, 'store'])->name('admin.contact.store');
        Route::get('/trash', [AdminContactController::class, 'trash'])->name('admin.contact.trash');
        Route::get('/{contact}/edit', [AdminContactController::class, 'edit'])->name('admin.contact.edit');
        Route::put('/{contact}/update', [AdminContactController::class, 'update'])->name('admin.contact.update');
        Route::get('/{contact}/show', [AdminContactController::class, 'show'])->name('admin.contact.show');
        Route::get('/{contact}/status', [AdminContactController::class, 'status'])->name('admin.contact.status');
        Route::get('/{contact}/delete', [AdminContactController::class, 'delete'])->name('admin.contact.delete');
        Route::get('/{contact}/restore', [AdminContactController::class, 'restore'])->name('admin.contact.restore');
        Route::delete('/{contact}/destroy', [AdminContactController::class, 'destroy'])->name('admin.contact.destroy');
    });
});

Route::get('/post/new', [App\Http\Controllers\Frontend\PostController::class, 'create'])->name('post.new');

// Route cho trang thanh toán

Route::post('/checkout-direct', [CartController::class, 'checkoutDirect'])->name('site.checkout.direct');



