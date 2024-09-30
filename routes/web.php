<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\StorekeeperController;

use App\Http\Controllers\KYCController;
use Illuminate\Support\Facades\Auth;


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');  // Redirect to the homepage or any other route after logout
})->name('logout');
// Routes for Admin role
// Route::group(['middleware' => ['role:Admin']], function() {
//     Route::resource('admin/couriers', CourierController::class);
//     Route::resource('admin/storekeepers', StorekeeperController::class);
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//  });

// Routes for Super Admin role
Route::group(['middleware' => ['role:Super Admin']], function() {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/admin/create', [AdminController::class, 'createForm'])->name('admin.create.form'); 
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register'); 
});
// Admin Routes
Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Courier routes
        Route::get('/couriers', [CourierController::class, 'index'])->name('admin.couriers.index');
    
        Route::get('/admin/couriers/create', [CourierController::class, 'create'])->name('admin.couriers.create'); // Show create form
        Route::post('/admin/couriers', [CourierController::class, 'store'])->name('admin.couriers.store'); // Store new courier
        Route::get('/admin/couriers/{id}/edit', [CourierController::class, 'edit'])->name('admin.couriers.edit'); // Show edit form
        Route::put('/admin/couriers/{id}', [CourierController::class, 'update'])->name('admin.couriers.update'); // Update courier
        Route::delete('/admin/couriers/{id}', [CourierController::class, 'destroy'])->name('admin.couriers.delete'); // Delete courier
    
        // Storekeeper routes
        Route::get('/storekeepers', [StorekeeperController::class, 'index'])->name('admin.storekeepers.index');
        Route::get('/admin/storekeepers/create', [StorekeeperController::class, 'create'])->name('admin.storekeepers.create'); // Show create form
        Route::post('/admin/storekeepers', [StorekeeperController::class, 'store'])->name('admin.storekeepers.store'); // Store new storekeeper
        Route::get('/admin/storekeepers/{id}/edit', [StorekeeperController::class, 'edit'])->name('admin.storekeepers.edit'); // Show edit form
        Route::put('/admin/storekeepers/{id}', [StorekeeperController::class, 'update'])->name('admin.storekeepers.update'); // Update storekeeper
        Route::delete('/admin/storekeepers/{id}', [StorekeeperController::class, 'destroy'])->name('admin.storekeepers.delete'); // Delete storekeeper
    
});

// Courier Routes
Route::group(['middleware' => ['auth', 'role:Courier']], function () {
    // Courier dashboard
    Route::get('/courier/dashboard', [CourierController::class, 'dashboard'])->name('courier.dashboard');

    // View orders assigned to the courier
    Route::get('/courier/orders', [CourierController::class, 'viewOrders'])->name('courier.orders');

    // Start delivery
    Route::post('/courier/orders/{order}/start', [CourierController::class, 'startDelivery'])->name('courier.orders.start');

    // Complete delivery
    Route::post('/courier/orders/{order}/complete', [CourierController::class, 'completeDelivery'])->name('courier.orders.complete');
});

// Storekeeper Routes
Route::group(['middleware' => ['auth', 'role:Storekeeper']], function () {
    // Storekeeper dashboard
    Route::get('/storekeeper/dashboard', [StorekeeperController::class, 'dashboard'])->name('storekeeper.dashboard');

    // Manage products
    Route::resource('storekeeper/products', StorekeeperController::class);

    // View orders to fulfill
    Route::get('/storekeeper/orders', [StorekeeperController::class, 'viewOrders'])->name('storekeeper.orders');

    // Fulfill an order
    Route::post('/storekeeper/orders/{order}/fulfill', [StorekeeperController::class, 'fulfillOrder'])->name('storekeeper.orders.fulfill');
});
Route::get('/kyc/{user}', [KYCController::class, 'showKYCForm'])->name('kyc.form');
Route::post('/kyc/{user}', [KYCController::class, 'submitKYC'])->name('kyc.submit');
// Routes for managing users (accessible by Admin and Super Admin)
Route::group(['middleware' => ['permission:manage users']], function() {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// Dashboard accessible by Admin and Super Admin
Route::group(['middleware' => ['role:Admin|Super Admin']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::get('/client/register', [ClientController::class, 'showRegisterForm'])->name('client.register.form');
Route::post('/client/register', [ClientController::class, 'register'])->name('client.register');

// Optional: Route to the client dashboard (after registration)
Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');

// Authentication routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);

// Public client, courier, and storekeeper pages
Route::get('client-page', function () { return view('client'); })->name('client.page');
Route::get('courier-page', function () { return view('courier'); })->name('courier.page');
Route::get('storekeeper-page', function () { return view('storekeeper'); })->name('storekeeper.page');
Route::get('admin-page', function () { return view('admin'); })->name('admin.page');

Route::middleware(['auth'])->group(function () {
    Route::get('/client/profile', [ProfileController::class, 'index'])->name('client.profile');
    Route::put('/client/profile', [ProfileController::class, 'update'])->name('client.profile.update');
    Route::get('/client/upgrade/form', [ClientController::class, 'showUpgradeForm'])->name('client.upgrade.form');
    Route::post('/client/upgrade', [ClientController::class, 'upgradeToMerchant'])->name('client.upgrade');
    Route::get('/client/support', [SupportController::class, 'show'])->name('client.support');
    Route::post('/client/support', [SupportController::class, 'submit'])->name('client.support.submit');
    Route::get('/merchant/dashboard', [MerchantController::class, 'dashboard'])->name('merchant.dashboard');
    Route::get('/client/orders', [OrderController::class, 'index'])->name('client.orders');
    Route::get('/client/orders/{id}', [OrderController::class, 'show'])->name('client.orders.show');
});
