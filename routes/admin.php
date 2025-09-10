<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function ()
{
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('/users', UserController::class, ['as' => 'admin']);
});
