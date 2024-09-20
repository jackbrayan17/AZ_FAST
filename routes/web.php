<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

// Routes for Admin role
Route::group(['middleware' => ['role:Admin']], function() {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
 });

// Routes for Super Admin role
Route::group(['middleware' => ['role:Super Admin']], function() {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/admin/create', [AdminController::class, 'createForm'])->name('admin.create.form'); 
    Route::post('/admin/create', [AdminController::class, 'create'])->name('admin.create'); 
});

// Routes for managing users (accessible by Admin and Super Admin)
Route::group(['middleware' => ['permission:manage users']], function() {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// Dashboard accessible by Admin and Super Admin
Route::group(['middleware' => ['role:Admin|Super Admin']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

// Client registration
Route::post('/client/register', [ClientController::class, 'register'])->name('client.register');

// Authentication routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);

// Public client, courier, and storekeeper pages
Route::get('client-page', function () { return view('client'); })->name('client.page');
Route::get('courier-page', function () { return view('courier'); })->name('courier.page');
Route::get('storekeeper-page', function () { return view('storekeeper'); })->name('storekeeper.page');
Route::get('admin-page', function () { return view('admin'); })->name('admin.page');
