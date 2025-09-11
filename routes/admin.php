<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\User\GuruController;
use App\Http\Controllers\Admin\User\SiswaController;
use App\Http\Controllers\Admin\User\OrangtuaController;


Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function ()
{
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/users', UserController::class);

    Route::resource('/guru', GuruController::class);

    Route::resource('/siswa', SiswaController::class);
});
