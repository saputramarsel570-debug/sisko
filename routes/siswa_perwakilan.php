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


Route::prefix('siswa_perwakilan')->middleware(['auth', 'role:siswa_perwakilan'])->group(function ()
{
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('siswa_perwakilan.dashboard.index');
    
    Route::resource('/jadwal', JadwalController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/absensi', AbsensiController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/guru', GuruController::class, ['as' => 'siswa']);
    Route::resource('/orangtua', OrangtuaController::class, ['as' => 'siswa']);
    Route::resource('/siswa', SiswaController::class, ['as' => 'siswa']);
    Route::resource('/kelas', KelasController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/mapel', MataPelajaranController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/jadwal-pelajaran', JadwalPelajaranController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'siswa_perwakilan']);

});