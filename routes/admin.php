<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\User\GuruController;
use App\Http\Controllers\Admin\User\SiswaController;
use App\Http\Controllers\Admin\User\OrangtuaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\JadwalPelajaranController;
use App\Http\Controllers\Admin\KeluhanSaranController;
use App\Http\Controllers\Admin\PengaturanSekolahController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\EkstrakurikulerController;
use App\Http\Controllers\Admin\JadwalEkskulController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\RekapJurnalController;
use App\Models\KeluhanSaran;
use App\Http\Controllers\NotificationsController;


Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function ()
{
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

    Route::resource('/users', UserController::class);

    Route::get('/guru/export', [GuruController::class, 'export'])->name('guru.export');

    Route::resource('/guru', GuruController::class);

    Route::get('/siswa/export', [SiswaController::class, 'export'])->name('siswa.export');

    Route::resource('/siswa', SiswaController::class);

    Route::resource('/orangtua', OrangtuaController::class);

    Route::get('/kelas/export', [KelasController::class, 'export'])->name('kelas.export');

    Route::resource('/kelas', KelasController::class)->parameters(['kelas' => 'kelas']);

    Route::post('/mapel/import', [MataPelajaranController::class, 'import'])->name('mapel.import');

    Route::post('/kelas/import', [KelasController::class, 'import'])->name('kelas.import');

    Route::post('/jadwal/import', [JadwalPelajaranController::class, 'import'])->name('jadwal.import');

    Route::post('/guru/import', [GuruController::class, 'import'])->name('guru.import');

    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');

    Route::get('/jadwal-ekskul/export', [JadwalEkskulController::class, 'export'])->name('jadwal_ekskul.export');

    Route::get('/ekskul/export', [EkstrakurikulerController::class, 'export'])->name('ekskul.export');

    Route::get('/export', [JadwalPelajaranController::class, 'export'])->name('jadwal.export');

    Route::get('/mapel/export', [MataPelajaranController::class, 'export'])->name('mapel.export');

    Route::get('/absensi/rekap', [AbsensiController::class, 'rekap'])->name('absensi.rekap');

    Route::get('/absensi/export', [AbsensiController::class, 'export'])->name('absensi.export');

    Route::resource('/mapel', MataPelajaranController::class);
    Route::get('/pengumuman/arsip', [App\Http\Controllers\Admin\PengumumanController::class, 'arsip'])
        ->name('pengumuman.arsip');
    Route::resource('/pengumuman', PengumumanController::class);

    Route::resource('/keluhan_saran', KeluhanSaranController::class);

    Route::resource('/ekskul', EkstrakurikulerController::class);

    Route::resource('/jadwal_ekskul', JadwalEkskulController::class);

    Route::get('/jurnal/rekap', [RekapJurnalController::class, 'index'])->name('jurnal.rekap');
});

Route::prefix('admin/jadwal')->middleware(['auth', 'role:admin'])->name('admin.jadwal.')->group(function () {
    Route::get('/', [JadwalPelajaranController::class, 'index'])->name('index');
    Route::get('/{kelas}/edit', [JadwalPelajaranController::class, 'edit'])->name('edit');
    Route::post('/{kelas}', [JadwalPelajaranController::class, 'updateSchedule'])->name('updateSchedule');
});
Route::get('/notifications/{id}/read', [NotificationsController::class, 'read'])->name('notifications.read');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/pengaturan', [PengaturanSekolahController::class, 'index'])->name('pengaturan.index');
    Route::get('/pengaturan/{id}/edit', [PengaturanSekolahController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan/{id}', [PengaturanSekolahController::class, 'update'])->name('pengaturan.update');
});

Route::get('/jadwal/export-pdf/{kelasId?}', [JadwalController::class, 'exportPdf'])
    ->name('jadwal.exportPdf');

Route::get('/admin/jurnal/rekap/export-pdf', [RekapJurnalController::class, 'exportPdf'])
    ->name('admin.jurnal.rekap.export');

Route::get('/absensi/export-pdf', [AbsensiController::class, 'exportPdf'])
    ->name('admin.absensi.exportPdf');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
});
