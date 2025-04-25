<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SettingController;

// Route homepage
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Route dashboard (dengan middleware auth & verified)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// // Route untuk menyimpan logo
Route::post('/store-logo', [SettingController::class, 'store'])->name('store.logo');

// Route tambahan dari file lain
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';


use App\Http\Controllers\UserController;

Route::get('/population_data', [UserController::class, 'index1'])->name('population_data');
Route::get('/stunting', [UserController::class, 'index2'])->name('stunting');
Route::get('/pandu-genre', [UserController::class, 'index3'])->name('pandu-genre');
Route::get('/baduta', [UserController::class, 'index4'])->name('baduta');
Route::get('/bumil', [UserController::class, 'index5'])->name('bumil');
Route::get('/catin', [UserController::class, 'index6'])->name('catin');
Route::get('/pasca-persalinan', [UserController::class, 'index7'])->name('pasca-persalinan');
Route::get('/kinerja-tpk', [UserController::class, 'index8'])->name('kinerja-tpk');
Route::get('/manajemen-user', [UserController::class, 'index9'])->name('manajemen-user');