<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DataMaster\RoleController;
use App\Http\Controllers\Dashboard\DataMaster\UserController;
use App\Http\Controllers\Dashboard\DataMaster\PermissionController;

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
});