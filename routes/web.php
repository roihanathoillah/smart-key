<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/super-admin', [DashboardController::class, 'superAdmin'])->name('super.admin');
Route::get('/super-admin/karyawan', [DashboardController::class, 'superAdminEmployees'])->name('karyawan.super');
Route::get('/super-admin/history', [DashboardController::class, 'superAdminHistory'])->name('history.super');
Route::get('/karyawan', [DashboardController::class, 'employees'])->name('karyawan');
Route::get('/history', [DashboardController::class, 'history'])->name('history');
Route::get('/history/export', [DashboardController::class, 'historyExport'])->name('history.export');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::get('/super-admin/profile', [DashboardController::class, 'superAdminProfile'])->name('profile.super');
Route::get('/checkin', [DashboardController::class, 'checkin'])->name('checkin');
