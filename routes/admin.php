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
use App\Http\Controllers\Admin\EkstrakurikulerController;
use App\Http\Controllers\Admin\JadwalEkskulController;
use App\Http\Controllers\Admin\KalenderAkademikController;
use App\Models\KeluhanSaran;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function ()
{
    Route::resource('/users', UserController::class);

    Route::resource('/guru', GuruController::class);

    Route::resource('/siswa', SiswaController::class);

    Route::resource('/orangtua', OrangtuaController::class);

    Route::resource('/kelas', KelasController::class)->parameters(['kelas' => 'kelas']);

    Route::post('/mapel/import', [MataPelajaranController::class, 'import'])->name('mapel.import');

    Route::post('/kelas/import', [KelasController::class, 'import'])->name('kelas.import');

    Route::post('/jadwal/import', [JadwalPelajaranController::class, 'import'])->name('jadwal.import');

    Route::post('/guru/import', [GuruController::class, 'import'])->name('guru.import');

    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');

    Route::resource('/mapel', MataPelajaranController::class);

    Route::resource('/pengumuman', PengumumanController::class);

    Route::resource('/keluhan_saran', KeluhanSaranController::class);

    Route::resource('/ekskul', EkstrakurikulerController::class);

    Route::resource('/jadwal_ekskul', JadwalEkskulController::class);

    Route::resource('/kalender_akademik', KalenderAkademikController::class);
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
   Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
   Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
   Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
});
