<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DataMaster\RoleController;
use App\Http\Controllers\Dashboard\DataMaster\UserController;
use App\Http\Controllers\Dashboard\Management\MineController;
use App\Http\Controllers\Dashboard\Booking\BookingController;
use App\Http\Controllers\Dashboard\Management\RegionController;
use App\Http\Controllers\Dashboard\Management\OfficeController;
use App\Http\Controllers\Dashboard\Approval\ApprovalController;
use App\Http\Controllers\Dashboard\Management\VehicleController;
use App\Http\Controllers\Dashboard\Management\EmployeeController;
use App\Http\Controllers\Dashboard\DataMaster\PermissionController;
use App\Http\Controllers\Dashboard\Management\VehicleUsageController;

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

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'todoLogin'])->name('todoLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Master
    Route::prefix('data-master')->group(function () {
        //Permission
        Route::resource('permission', PermissionController::class)->except(['show', 'edit', 'update']);

        //Role
        Route::resource('role', RoleController::class)->except(['show']);

        //User
        Route::resource('user', UserController::class)->except(['show']);
    });


    //Data Management
    Route::prefix('management')->group(function () {
        //Region
        Route::resource('region', RegionController::class)->except(['show', 'edit', 'update']);

        //Office
        Route::resource('office', OfficeController::class)->except(['show']);

        //Mine
        Route::resource('mine', MineController::class)->except(['show']);

        //Employee
        Route::resource('employee', EmployeeController::class)->except(['show']);

        //Vehicle
        Route::resource('vehicle', VehicleController::class)->except(['show']);

        //Vehicle Usage
        Route::resource('vehicle-usage', VehicleUsageController::class)->except(['show', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::get('vehicle-usage/{vehicle_usage}/off-duty', [VehicleUsageController::class, 'offDuty'])->name('vehicle-usage.off-duty');
    });

    //Booking
    Route::resource('booking', BookingController::class)->except(['show']);
    Route::get('booking/{booking}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::get('booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');
    
    //Export Booking
    Route::get('booking/searchexport', [BookingController::class, 'searchexport'])->name('booking.searchexport');
    Route::get('booking/export', [BookingController::class, 'export'])->name('booking.export');

    //Approval
    Route::resource('approval', ApprovalController::class)->except(['show', 'create', 'store', 'edit', 'update']);
});