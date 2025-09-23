<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guru\DashboardController;
use App\Http\Controllers\Guru\JurnalController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Guru\SiswaController;
use App\Http\Controllers\Guru\OrangtuaController;
use App\Http\Controllers\Guru\KelasController;
use App\Http\Controllers\Guru\JadwalPelajaranController;
use App\Http\Controllers\Guru\MataPelajaranController;
use App\Http\Controllers\Guru\PengumumanController;
use App\Http\Controllers\Guru\ProfileController;
use App\Http\Controllers\Guru\KeluhanController;
use App\Http\Controllers\Guru\AbsensiController;


Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function ()
{
    Route::resource('/guru', GuruController::class, ['as' => 'guru']);
    Route::resource('/kelas', KelasController::class, ['as' => 'guru']);
    Route::resource('/siswa', SiswaController::class, ['as' => 'guru']);
    Route::resource('/orangtua', OrangtuaController::class, ['as' => 'guru']);
    Route::resource('/jadwal', JadwalController::class, ['as' => 'guru']);
    Route::resource('/jadwal-pelajaran', JadwalPelajaranController::class, ['as' => 'guru']);
    Route::resource('/mapel', MataPelajaranController::class, ['as' => 'guru']);
    Route::resource('/jurnal', JurnalController::class, ['as' => 'guru']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'guru']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'guru']);
    Route::resource('/absensi', AbsensiController::class, ['as' => 'guru']);
});

Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
 });