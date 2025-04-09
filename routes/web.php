<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PaymentTermController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OrderSupplierController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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
    Route::resource('customer', CustomerController::class);
    Route::resource('workflow', WorkflowController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('payment_term', PaymentTermController::class);
    Route::resource('transaction', TransactionController::class);
    Route::resource('attribute', AttributeController::class);

    // Transaction 
    // Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    // Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
    // Route::get('/transaction/{id}/show', [TransactionController::class, 'show'])->name('transaction.show'); 
    // Route::delete('/transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

    Route::get('/transaction/{id}/add_product', [TransactionController::class, 'add_product'])->name('transaction.add_product');
    Route::post('/transaction/store_product', [TransactionController::class, 'store_product'])->name('transaction.store_product');
    Route::get('/transaction/{id}/edit_product', [TransactionController::class, 'edit_product'])->name('transaction.edit_product');
    Route::patch('/transaction/update_product/{id}', [TransactionController::class, 'update_product'])->name('transaction.update_product');
    // Route::get('/transaction/destroy_product/{id}/{$transaction_id}', [TransactionController::class, 'destroy_product'])->name('transaction.destroy_product');

    Route::delete('/transaction/{transaction}/product/{product}', [TransactionController::class, 'destroy_product'])->name('transaction.destroy_product');
    Route::get('/transaction/{id}/add_payment', [TransactionController::class, 'add_payment'])->name('transaction.add_payment');
    Route::post('/transaction/store_payment', [TransactionController::class, 'store_payment'])->name('transaction.store_payment');
    Route::delete('/transaction/{transaction}/payment/{payment}', [TransactionController::class, 'destroy_payment'])->name('transaction.delete_payment');
    Route::patch('/transaction/update_status_supplier/{id}', [TransactionController::class, 'update_status_supplier'])->name('transaction.update_status_supplier');
    

    Route::resource('payment', PaymentController::class);
    Route::resource('order_supplier', OrderSupplierController::class);

});

require __DIR__.'/auth.php';