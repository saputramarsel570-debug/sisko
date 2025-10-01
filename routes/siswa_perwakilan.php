<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiswaPerwakilan\JadwalController;
use App\Http\Controllers\SiswaPerwakilan\AbsensiController;
use App\Http\Controllers\SiswaPerwakilan\GuruController;
use App\Http\Controllers\SiswaPerwakilan\SiswaController;
use App\Http\Controllers\SiswaPerwakilan\OrangtuaController;
use App\Http\Controllers\SiswaPerwakilan\PengumumanController;
use App\Http\Controllers\SiswaPerwakilan\KelasController;
use App\Http\Controllers\SiswaPerwakilan\MataPelajaranController;
use App\Http\Controllers\SiswaPerwakilan\JadwalPelajaranController;
use App\Http\Controllers\SiswaPerwakilan\KeluhanController;
use App\Http\Controllers\SiswaPerwakilan\DashboardController;
use App\Http\Controllers\SiswaPerwakilan\ProfileController;
use App\Http\Controllers\SiswaPerwakilan\JadwalEkskulController;

Route::prefix('siswa_perwakilan')->middleware(['auth', 'role:siswa_perwakilan'])->group(function ()
{
    Route::resource('/jadwal', JadwalController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/absensi', AbsensiController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/guru', GuruController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/orangtua', OrangtuaController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/siswa', SiswaController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/kelas', KelasController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/mapel', MataPelajaranController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/jadwal_ekskul', JadwalEkskulController::class, ['as' => 'siswa_perwakilan']);
});
Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('siswa_perwakilan.absensi.rekap');
Route::put('/absensi/update-bulk', [AbsensiController::class, 'updateBulk'])->name('siswa_perwakilan.absensi.update_bulk');

Route::prefix('siswa_perwakilan')->middleware(['auth', 'role:siswa_perwakilan'])->name('siswa_perwakilan.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SiswaPerwakilan\DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('siswa_perwakilan')->middleware(['auth', 'role:siswa_perwakilan'])->name('siswa_perwakilan.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
});
