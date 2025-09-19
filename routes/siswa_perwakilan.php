<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiswaPerwakilan\JadwalController;
use App\Http\Controllers\SiswaPerwakilan\AbsensiController;
use App\Http\Controllers\SiswaPerwakilan\PengumumanController;
use App\Http\Controllers\SiswaPerwakilan\KelasController;
use App\Http\Controllers\SiswaPerwakilan\MataPelajaranController;
use App\Http\Controllers\SiswaPerwakilan\JadwalPelajaranController;
use App\Http\Controllers\SiswaPerwakilan\KeluhanController;
use App\Http\Controllers\SiswaPerwakilan\DashboardController;


Route::prefix('siswa-perwakilan')->middleware(['auth', 'role:siswa_perwakilan'])->group(function ()
{
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('siswa-perwakilan.dashboard');
    
    Route::resource('/jadwal', JadwalController::class, ['as' => 'siswa-perwakilan']);
    Route::resource('/absensi', AbsensiController::class, ['as' => 'siswa-perwakilan']);
    Route::resource('/kelas', KelasController::class, ['as' => 'siswa-perwakilan']);
    Route::resource('/mapel', MataPelajaranController::class, ['as' => 'siswa-perwakilan']);
    Route::resource('/jadwal-pelajaran', JadwalPelajaranController::class, ['as' => 'siswa-perwakilan']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'siswa-perwakilan']);
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'siswa-perwakilan']);

});