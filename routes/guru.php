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
use App\Http\Controllers\Guru\PengaturanSekolahController;

Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::resource('/guru', GuruController::class);
    Route::resource('/kelas', KelasController::class);
    Route::resource('/siswa', SiswaController::class);
    Route::resource('/orangtua', OrangtuaController::class);
    Route::resource('/jadwal-pelajaran', JadwalPelajaranController::class);
    Route::resource('/mapel', MataPelajaranController::class);
    Route::resource('/jurnal', JurnalController::class);
    Route::resource('/pengumuman', PengumumanController::class);
    Route::resource('/keluhan', KeluhanController::class);
    Route::resource('/absensi', AbsensiController::class);

    Route::get('/absensi/riwayat', [AbsensiController::class, 'show'])->name('absensi.show');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
});
Route::prefix('guru')->middleware(['auth', 'role:guru'])->name('guru.')->group(function () {
    Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])->name('pengaturan.index');
    });