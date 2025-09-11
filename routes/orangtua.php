<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Orangtua\DashboardController;
use App\Http\Controllers\Orangtua\AbsensiController;
use App\Http\Controllers\Orangtua\PengumumanController;
use App\Http\Controllers\Orangtua\KeluhanController;

Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->group(function ()
{
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('orangtua.dashboard');

    Route::resource('/absensi', AbsensiController::class, ['as' => 'orangtua']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'orangtua']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'orangtua']);
});
