<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    
    return "You are logged in as ADMIN!";
})->middleware(['auth', 'verified','role:admin']);

Route::get('/operator', function () {
    return "You are logged in as OPERATOR!";
})->middleware(['auth', 'verified','role:operator|admin']);


Route::middleware(['auth', 'verified','role_or_permission:admin|operator'])->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/{id}/show', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::patch('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/{id}/show', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::patch('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

});


Route::middleware(['auth', 'verified','role_or_permission:admin'])->group(function () {
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::patch('/setting', [SettingController::class, 'update'])->name('setting.update');

});

require __DIR__.'/auth.php';
