<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Halaman utama sementara untuk shop.index sebelum Milestone 4
Route::get('/', function () {
    return auth()->check()
        ? view('layouts.app') 
        : redirect()->route('login');
})->name('shop.index');

// Auth routes (M1.8)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Placeholder sementara untuk admin.dashboard sebelum Milestone 2 & 7
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return '<h1>Dashboard Admin (Milestone 1 Teruji)</h1><p>Login role admin berhasil! Silakan lanjut ke Milestone 2.</p><form method="POST" action="'.route('logout').'">'.csrf_field().'<button>Keluar</button></form>';
    })->name('dashboard');
});
