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


Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function ()
{   
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('siswa.dashboard.index');
    
    
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

});