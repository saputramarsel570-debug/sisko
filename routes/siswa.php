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

Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function ()
{   
    Route::resource('/jadwal', JadwalController::class, ['as' => 'siswa']);
    Route::resource('/kelas', KelasController::class, ['as' => 'siswa']);
    Route::resource('/guru', GuruController::class, ['as' => 'siswa']);
    Route::resource('/orangtua', OrangtuaController::class, ['as' => 'siswa']);
    Route::resource('/siswa', SiswaController::class, ['as' => 'siswa']);
    Route::resource('/mapel', MataPelajaranController::class, ['as' => 'siswa']);
    Route::resource('/jadwal-pelajaran', JadwalPelajaranController::class, ['as' => 'siswa']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'siswa']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'siswa']);
    Route::resource('/absensi', AbsensiController::class, ['as' => 'siswa']);
    Route::resource('/jadwal_ekskul', JadwalEkskulController::class, ['as' => 'siswa']);
});

Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
});
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->name('siswa.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
 });
 