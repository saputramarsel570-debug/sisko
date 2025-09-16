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
use App\Models\KeluhanSaran;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function ()
{
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/users', UserController::class);

    Route::resource('/guru', GuruController::class);

    Route::resource('/siswa', SiswaController::class);

    Route::resource('/orangtua', OrangtuaController::class);

    Route::resource('/kelas', KelasController::class);

    Route::resource('/mapel', MataPelajaranController::class);

    Route::resource('/keluhan_saran', KeluhanSaranController::class);
});

Route::prefix('admin/jadwal')->middleware(['auth', 'role:admin'])->name('admin.jadwal.')->group(function () {
    Route::get('/', [JadwalPelajaranController::class, 'index'])->name('index');
    Route::get('/{kelas}/edit', [JadwalPelajaranController::class, 'edit'])->name('edit');
    Route::post('/{kelas}', [JadwalPelajaranController::class, 'updateSchedule'])->name('updateSchedule');
});
