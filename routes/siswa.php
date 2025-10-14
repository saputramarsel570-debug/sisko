<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Siswa\JadwalController;
use App\Http\Controllers\Siswa\PengumumanController;
use App\Http\Controllers\Siswa\GuruController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\Siswa\OrangtuaController;
use App\Http\Controllers\Siswa\KelasController;
use App\Http\Controllers\Siswa\MataPelajaranController;
use App\Http\Controllers\Siswa\JadwalPelajaranController;
use App\Http\Controllers\Siswa\KeluhanController;
use App\Http\Controllers\Siswa\AbsensiController;
use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\ProfileController;
use App\Http\Controllers\Siswa\JadwalEkskulController;
use App\Http\Controllers\Siswa\PengaturanSekolahController;
use App\Http\Controllers\Siswa\RekapAbsensiController;
use App\Http\Controllers\NotificationsController;

Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function ()
{
    Route::resource('/jadwal', JadwalController::class, ['as' => 'siswa']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'siswa']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'siswa']);
    Route::resource('/absensi', AbsensiController::class, ['as' => 'siswa']);
    Route::resource('/jadwal_ekskul', JadwalEkskulController::class, ['as' => 'siswa']);
});

Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
});
Route::get('/notifications/{id}/read', [NotificationsController::class, 'read'])->name('notifications.read');

Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {
    Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])->name('pengaturan.index');
    });

Route::get('/jadwal/export-pdf/{kelasId?}', [JadwalController::class, 'exportPdf'])
    ->name('jadwal.exportPdf');

    Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    });