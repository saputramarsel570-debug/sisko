<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Orangtua\DashboardController;
use App\Http\Controllers\Orangtua\JadwalController;
use App\Http\Controllers\Orangtua\GuruController;
use App\Http\Controllers\Orangtua\SiswaController;
use App\Http\Controllers\Orangtua\OrangtuaController;
use App\Http\Controllers\Orangtua\KelasController;
use App\Http\Controllers\Orangtua\MataPelajaranController;
use App\Http\Controllers\Orangtua\JadwalPelajaranController;
use App\Http\Controllers\Orangtua\AbsensiController;
use App\Http\Controllers\Orangtua\PengumumanController;
use App\Http\Controllers\Orangtua\KeluhanController;
use App\Http\Controllers\Orangtua\ProfileController;
use App\Http\Controllers\Orangtua\JadwalEkskulController;
use App\Http\Controllers\Orangtua\PengaturanSekolahController;
use App\Http\Controllers\NotificationsController;

Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->group(function ()
{
    Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->name('orangtua.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Orangtua\DashboardController::class, 'index'])->name('dashboard');
    });

    Route::resource('/absensi', AbsensiController::class, ['as' => 'orangtua']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'orangtua']);
    Route::get('/orangtua/pengumuman/arsip', [App\Http\Controllers\Orangtua\PengumumanController::class, 'arsip'])
        ->name('orangtua.pengumuman.arsip');
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'orangtua']);
    Route::resource('/jadwal_ekskul', JadwalEkskulController::class, ['as' => 'orangtua']);
});

 Route::get('/notifications/{id}/read', [NotificationsController::class, 'read'])->name('notifications.read');

 Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->name('orangtua.')->group(function () {
    Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])->name('pengaturan.index');
    });

    Route::middleware(['auth', 'role:orangtua'])->prefix('orangtua')->name('orangtua.')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    });