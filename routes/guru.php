<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guru\DashboardController;
use App\Http\Controllers\Guru\LihatController;
use App\Http\Controllers\Guru\JurnalController;
use App\Http\Controllers\Guru\PengumumanController;
use App\Http\Controllers\Guru\KeluhanController;


Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function ()
{
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('guru.dashboard');

    Route::resource('/lihat', LihatController::class, ['as' => 'guru']);
    Route::resource('/jurnal', JurnalController::class, ['as' => 'guru']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'guru']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'guru']);
});