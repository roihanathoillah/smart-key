<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananPekerjaanController;

// ====================
// LANDING PAGE
// ====================

Route::get('/', function () {
    return view('landing');
})->name('landing');

// ====================
// AUTH
// ====================

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


// ====================
// ADMIN
// ====================

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/karyawan', [DashboardController::class, 'employees'])->name('karyawan');

    Route::post('/karyawan', [DashboardController::class, 'storeEmployee'])
        ->name('karyawan.store');

    Route::put('/karyawan/{id}', [DashboardController::class, 'updateEmployee'])
        ->name('karyawan.update');

    Route::delete('/karyawan/{id}', [DashboardController::class, 'deleteEmployee'])
        ->name('karyawan.delete');

    Route::get('/history', [DashboardController::class, 'history'])->name('history');

    Route::get('/history/export', [DashboardController::class, 'historyExport'])->name('history.export');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::get('/checkin', [DashboardController::class, 'checkin'])->name('checkin');

    Route::post('/checkin', [DashboardController::class, 'storeCheckin'])
        ->name('checkin.store');

    Route::post('/checkin/checkout', [DashboardController::class, 'storeCheckout'])
        ->name('checkin.checkout');
});


// ====================
// SUPER ADMIN
// ====================

Route::middleware('superadmin')->prefix('super-admin')->group(function () {

    Route::get('/', [DashboardController::class, 'superAdmin'])
        ->name('super.admin');

    Route::get('/karyawan', [DashboardController::class, 'superAdminEmployees'])
        ->name('karyawan.super');

    Route::post('/karyawan', [DashboardController::class, 'storeSuperAdminEmployee'])
        ->name('karyawan.super.store');

    // Edit data karyawan
    Route::put('/karyawan/{id}', [DashboardController::class, 'updateSuperAdminEmployee'])
        ->name('karyawan.super.update');

    // Hapus data karyawan
    Route::delete('/karyawan/{id}', [DashboardController::class, 'deleteSuperAdminEmployee'])
        ->name('karyawan.super.delete');

    // Approve karyawan
    Route::post('/karyawan/{id}/approve', [DashboardController::class, 'approveEmployee'])
        ->name('karyawan.approve');

    // Tolak karyawan
    Route::post('/karyawan/{id}/reject', [DashboardController::class, 'rejectEmployee'])
        ->name('karyawan.reject');

    // Aktifkan / Nonaktifkan karyawan dari modal Detail
    Route::patch('/karyawan/{id}/status', [DashboardController::class, 'updateSuperAdminEmployeeStatus'])
        ->name('karyawan.super.status');

    Route::get('/history', [DashboardController::class, 'superAdminHistory'])
        ->name('history.super');

    Route::get('/profile', [DashboardController::class, 'superAdminProfile'])
        ->name('profile.super');
});
