<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\User\GuruController;
use App\Http\Controllers\Admin\User\SiswaController;
use App\Http\Controllers\Admin\User\OrangtuaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\JadwalPelajaranController;
use App\Http\Controllers\Admin\KeluhanSaranController;
use App\Http\Controllers\Admin\PengaturanSekolahController;
use App\Http\Controllers\Admin\ProfileController;
use App\Models\KeluhanSaran;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function ()
{
    Route::resource('/users', UserController::class);

    Route::resource('/guru', GuruController::class);

    Route::resource('/siswa', SiswaController::class);

    Route::resource('/orangtua', OrangtuaController::class);

    Route::resource('/kelas', KelasController::class)->parameters(['kelas' => 'kelas']);

    Route::resource('/mapel', MataPelajaranController::class);

    Route::resource('/keluhan_saran', KeluhanSaranController::class);
});

Route::prefix('admin/jadwal')->middleware(['auth', 'role:admin'])->name('admin.jadwal.')->group(function () {
    Route::get('/', [JadwalPelajaranController::class, 'index'])->name('index');
    Route::get('/{kelas}/edit', [JadwalPelajaranController::class, 'edit'])->name('edit');
    Route::post('/{kelas}', [JadwalPelajaranController::class, 'updateSchedule'])->name('updateSchedule');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])->name('pengaturan.index');
    Route::get('/pengaturan/{id}/edit', [PengaturanSekolahController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan/{id}', [PengaturanSekolahController::class, 'update'])->name('pengaturan.update');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
   Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
   Route::post('/admin/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
});
