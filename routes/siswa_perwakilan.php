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
use App\Http\Controllers\SiswaPerwakilan\PengaturanSekolahController;
use App\Http\Controllers\SiswaPerwakilan\JadwalEkskulController;
use App\Http\Controllers\NotificationsController;

Route::prefix('siswa_perwakilan')->middleware(['auth', 'role:siswa_perwakilan'])->group(function ()
{
    Route::get('/absensi/export-pdf', [AbsensiController::class, 'exportPdf'])
        ->name('siswa_perwakilan.absensi.exportPdf');
    Route::resource('/jadwal', JadwalController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/absensi', AbsensiController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/pengumuman', PengumumanController::class, ['as' => 'siswa_perwakilan']);
    Route::get('/siswa_perwakilan/pengumuman/arsip', [App\Http\Controllers\SiswaPerwakilan\PengumumanController::class, 'arsip'])
        ->name('siswa_perwakilan.pengumuman.arsip');
    Route::resource('/keluhan', KeluhanController::class, ['as' => 'siswa_perwakilan']);
    Route::resource('/jadwal_ekskul', JadwalEkskulController::class, ['as' => 'siswa_perwakilan']);

});

Route::get('/notifications/{id}/read', [NotificationsController::class, 'read'])->name('notifications.read');

Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('siswa_perwakilan.absensi.rekap');
Route::put('/absensi/update-bulk', [AbsensiController::class, 'updateBulk'])->name('siswa_perwakilan.absensi.update_bulk');

Route::prefix('siswa_perwakilan')->middleware(['auth', 'role:siswa_perwakilan'])->name('siswa_perwakilan.')->group(function () {
Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])->name('pengaturan.index');
});

Route::get('/jadwal/export-pdf/{kelasId?}', [JadwalController::class, 'exportPdf'])
    ->name('jadwal.exportPdf');

Route::get('/absensi/export-pdf', [AbsensiController::class, 'exportPdf'])
    ->name('siswa_perwakilan.absensi.exportPdf');

Route::prefix('siswa_perwakilan')->middleware(['auth', 'role:siswa_perwakilan'])->name('siswa_perwakilan.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SiswaPerwakilan\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:siswa_perwakilan'])->prefix('siswa_perwakilan')->name('siswa_perwakilan.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
});
