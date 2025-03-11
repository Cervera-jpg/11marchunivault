<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\StockController as UserStockController;
use App\Http\Controllers\User\UserRequestController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\SupplyInventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


	Route::get('profile', function () {
		return view('profile');
	})->name('profile');


	Route::get('user-management', [UserManagementController::class, 'index'])->name('user-management');




    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);

    Route::resource('users', UserController::class);
    Route::resource('stock', StockController::class);
    Route::delete('/stock/{id}', [StockController::class, 'destroy'])->name('stock.destroy');

    Route::post('/change-password', [UserProfileController::class, 'changePassword'])->middleware('auth');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
	Route::get('/login', [SessionsController::class, 'create'])->name('login');
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/session', [SessionsController::class, 'store']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

// Welcome page (public)
Route::get('/', function () {
    return view('session.welcome');
})->name('welcome');

// Authentication Routes
Route::get('/login', [SessionsController::class, 'create'])->name('session.login');
Route::post('/login', [SessionsController::class, 'store']);
Route::get('/register', [RegisterController::class, 'create'])->name('session.register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [SessionsController::class, 'destroy'])->name('session.logout');

// Admin routes
Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
    Route::get('/reports/branches', [AdminReportController::class, 'getBranches'])->name('reports.branches');
    Route::get('/reports/print', [AdminReportController::class, 'print'])->name('reports.print');
    Route::resource('/categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    Route::resource('stocks', StockController::class);
    Route::get('/tables', [StockController::class, 'index'])->name('tables');
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('admin.user-management');
    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');

    // Request management routes
    Route::get('/requests', [AdminRequestController::class, 'index'])->name('requests.index');
    Route::put('/requests/{id}/update-status', [AdminRequestController::class, 'updateStatus'])->name('requests.update-status');
    Route::post('/requests/{id}/approve', [AdminRequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{id}/reject', [AdminRequestController::class, 'reject'])->name('requests.reject');

    Route::get('/inventory', [StockController::class, 'inventory'])->name('inventory');

    // Supply Inventory routes
    Route::get('/stock/supplyinventory', [SupplyInventoryController::class, 'create'])->name('stock.supplyinventory');
    Route::post('/stock/supplyinventory', [SupplyInventoryController::class, 'store'])->name('stock.supplyinventory.store');
    Route::get('/inventory', [SupplyInventoryController::class, 'index'])->name('inventory');
    
    // Edit routes
    Route::get('/stock/supplyinventory/{id}/edit', [SupplyInventoryController::class, 'edit'])->name('supplies.edit');
    Route::put('/stock/supplyinventory/{id}', [SupplyInventoryController::class, 'update'])->name('supplies.update');
    Route::delete('/stock/supplyinventory/{id}', [SupplyInventoryController::class, 'destroy'])->name('stock.supplyinventory.destroy');

    // Edit routes for supplies
    Route::get('/supplies/{id}/edit', [SupplyInventoryController::class, 'edit'])->name('supplies.edit');
    Route::put('/supplies/{id}', [SupplyInventoryController::class, 'update'])->name('supplies.update');
});

// User routes
Route::middleware(['auth', 'check.role:user'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Stocks (view only)
    Route::get('/tables', [UserStockController::class, 'index'])->name('tables'); // Changed from 'stocks' to 'tables'

    // Request routes
    Route::get('/create-request', [UserRequestController::class, 'create'])->name('requests.createreq');
    Route::post('/store-request', [UserRequestController::class, 'store'])->name('requests.store');
    Route::get('/view-requests', [UserRequestController::class, 'index'])->name('requests.viewrequests');
});

// Common auth routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [SessionsController::class, 'destroy'])->name('logout');
    // ... other common auth routes ...
    Route::get('/profile', function () {
        return view('laravel-examples.user-profile');
    })->name('user.profile');
});

Route::post('/upload-avatar', [UserProfileController::class, 'uploadAvatar'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('/password/change', [UserProfileController::class, 'changePassword'])->name('password.change');
});


