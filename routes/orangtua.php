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

Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->group(function ()
{
    Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->name('orangtua.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Orangtua\DashboardController::class, 'index'])->name('dashboard');
    });

    Route::resource('/jadwal', JadwalController::class, ['as' => 'orangtua']);
    Route::resource('/guru', GuruController::class, ['as' => 'orangtua']);
    Route::resource('/orangtua', OrangtuaController::class, ['as' => 'orangtua']);
    Route::resource('/kelas', KelasController::class, ['as' => 'orangtua']);
    Route::resource('/siswa', SiswaController::class, ['as' => 'orangtua']);
    Route::resource('/absensi', AbsensiController::class, ['as' => 'orangtua']);
    Route::resource('/mapel', MataPelajaranController::class, ['as' => 'orangtua']);
    Route::resource('/jadwal-pelajaran', JadwalPelajaranController::class, ['as' => 'orangtua']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'orangtua']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'orangtua']);
    Route::resource('/jadwal_ekskul', JadwalEkskulController::class, ['as' => 'orangtua']);
});
Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->name('orangtua.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');

    
 });

 Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->name('orangtua.')->group(function () {
    Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])->name('pengaturan.index');
    });