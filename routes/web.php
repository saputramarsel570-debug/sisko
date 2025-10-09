<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\SiswaPerwakilan\DashboardController as SiswaPerwakilanDashboardController;
use App\Http\Controllers\Orangtua\DashboardController as OrangtuaDashboardController;
use App\Models\User;
Use App\Http\Controllers\NotificationsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    return redirect()->route($role . '.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/notifications/read/{id}', function($id) {
    $notif = auth()->user()->notifications()->findOrFail($id);
    $notif->markAsRead();
    return redirect($notif->data['url'] ?? url('/dashboard'));
})->name('notifications.read');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/siswa', function () {
    return view('sis');
})->name('siswa');

Route::get('/guru', function () {
    return view('gurr');
})->name('guru');

Route::get('/orangtua', function () {
    return view('ortu');
})->name('ortu');

Route::get('/admin', function () {
    return view('adm');
})->name('admin');

require __DIR__.'/auth.php';
require __DIR__.'/siswa_perwakilan.php';
require __DIR__.'/admin.php';
require __DIR__.'/guru.php';
require __DIR__.'/siswa.php';
require __DIR__.'/orangtua.php';
