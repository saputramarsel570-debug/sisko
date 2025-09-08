<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// halaman awal (misalnya landing page atau welcome)
Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify'=> false,
    'confirm'=> false
]);

Route::group([
    'middleware' => ['auth']

], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // dashboard utama → redirect sesuai role user
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    return redirect()->route($role . '.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// route untuk profile (bawaan breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
});

Route::resource('/admin', App\Http\Controllers\AdminController::class);

// guru routes
Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard', fn () => view('guru.dashboard'))->name('guru.dashboard');
});

// siswa routes
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', fn () => view('siswa.dashboard'))->name('siswa.dashboard');
});

// orangtua routes
Route::prefix('orangtua')->middleware(['auth', 'role:orangtua'])->group(function () {
    Route::get('/dashboard', fn () => view('orangtua.dashboard'))->name('orangtua.dashboard');
});

// auth routes (bawaan breeze)
require __DIR__ . '/auth.php';
});
