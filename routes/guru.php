<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guru\DashboardController;
use App\Http\Controllers\Guru\JurnalController;
use App\Http\Controllers\Guru\RekapJurnalsController;
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
use App\Http\Controllers\Guru\AbsensirekController;
use App\Http\Controllers\Guru\JadwalController;
use App\Http\Controllers\Guru\PengaturanSekolahController;
use App\Http\Controllers\NotificationsController;


Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/export-pdf/{kelasId?}', [JadwalController::class, 'exportPdf'])
    ->name('jadwal.exportPdf');
    Route::resource('/jurnal', JurnalController::class);
    Route::get('/jurnals/rekap', [RekapJurnalsController::class, 'index'])->name('jurnals.rekap');
    Route::get('/jurnals/rekap/export-pdf', [RekapJurnalsController::class, 'exportPdf'])
    ->name('jurnals.rekap.export');

    Route::get('/pengumuman/arsip', [App\Http\Controllers\Guru\PengumumanController::class, 'arsip'])
        ->name('pengumuman.arsip');
    Route::resource('/pengumuman', PengumumanController::class);

    Route::resource('/keluhan', KeluhanController::class);
    Route::resource('/absensi', AbsensiController::class);

    Route::post('/guru/keluhan/{id}/balas', [App\Http\Controllers\Guru\KeluhanController::class, 'updateBalasan'])
        ->name('guru.keluhan.balas');

    Route::get('/notifications/{id}/read', [NotificationsController::class, 'read'])->name('notifications.read');
    

    Route::get('/absensi/riwayat', [AbsensiController::class, 'show'])->name('absensi.show');
    Route::get('/absensirek/rekap', [AbsensirekController::class, 'rekap'])->name('absensirek.rekap');
    Route::get('/absensirek/export', [AbsensirekController::class, 'export'])->name('absensirek.export');
    Route::get('/absensirek/export-pdf', [AbsensirekController::class, 'exportPdf'])->name('absensirek.exportPdf');
    Route::get('/guru/absensirek/export-pdf', [AbsensirekController::class, 'exportPdf'])->name('guru.absensirek.exportPdf');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});
Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])->name('pengaturan.index');
    });

    Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    });
