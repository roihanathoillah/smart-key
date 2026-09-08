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

/*
|--------------------------------------------------------------------------
| REGISTER PUBLIK
|--------------------------------------------------------------------------
|
| Register publik dinonaktifkan untuk menjaga keamanan role Super Admin.
| Super Admin baru dibuat melalui menu "Kelola Super Admin".
|
*/

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

    Route::put('/profile', [DashboardController::class, 'updateProfile'])
        ->name('profile.update');

    Route::post('/notifications/{id}/read', [DashboardController::class, 'markNotificationRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [DashboardController::class, 'markAllNotificationsRead'])
        ->name('notifications.readAll');

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

    Route::put('/karyawan/{id}', [DashboardController::class, 'updateSuperAdminEmployee'])
        ->name('karyawan.super.update');

    Route::delete('/karyawan/{id}', [DashboardController::class, 'deleteSuperAdminEmployee'])
        ->name('karyawan.super.delete');

    Route::post('/karyawan/{id}/approve', [DashboardController::class, 'approveEmployee'])
        ->name('karyawan.approve');

    Route::post('/karyawan/{id}/reject', [DashboardController::class, 'rejectEmployee'])
        ->name('karyawan.reject');

    Route::patch('/karyawan/{id}/status', [DashboardController::class, 'updateSuperAdminEmployeeStatus'])
        ->name('karyawan.super.status');

    Route::get('/history', [DashboardController::class, 'superAdminHistory'])
        ->name('history.super');
    Route::get('/notifikasi', [DashboardController::class, 'superAdminNotifications'])
        ->name('notifikasi.super');

    Route::get('/profile', [DashboardController::class, 'superAdminProfile'])
        ->name('profile.super');

    // Kelola Super Admin
    Route::get('/users', [DashboardController::class, 'superAdminUsers'])
        ->name('super.users');

    Route::post('/users', [DashboardController::class, 'storeSuperAdminUser'])
        ->name('super.users.store');

    Route::put('/users/{id}', [DashboardController::class, 'updateSuperAdminUser'])
        ->name('super.users.update');

    Route::delete('/users/{id}', [DashboardController::class, 'deleteSuperAdminUser'])
        ->name('super.users.delete');
    Route::put('/profile', [DashboardController::class, 'updateSuperAdminProfile'])
        ->name('profile.super.update');
});
