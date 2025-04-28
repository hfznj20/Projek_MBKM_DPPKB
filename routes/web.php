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

use App\Http\Controllers\BdtpkController;
use App\Http\Controllers\UserController;

// Bagian Admin
Route::get('/population_data', [UserController::class, 'index1'])->name('population_data');
Route::get('/stunting', [UserController::class, 'index2'])->name('stunting');
Route::get('/pandu-genre', [UserController::class, 'index3'])->name('pandu-genre');
Route::get('/baduta', [UserController::class, 'index4'])->name('baduta');
Route::get('/bumil', [UserController::class, 'index5'])->name('bumil');
Route::get('/catin', [UserController::class, 'index6'])->name('catin');
Route::get('/pasca-persalinan', [UserController::class, 'index7'])->name('pasca-persalinan');
Route::get('/kinerja-tpk', [UserController::class, 'index8'])->name('kinerja-tpk');
Route::get('/manajemen-user', [UserController::class, 'index9'])->name('manajemen-user');

// Bagian TPK
Route::get('/baduta_tpk', [UserController::class, 'index10'])->name('baduta-tpk');
Route::get('/population_data_tpk', [UserController::class, 'index11'])->name('PopulationDataTPK');
Route::get('/stunting-tpk', [UserController::class, 'index12'])->name('stunting-tpk');
Route::get('/bumil-tpk', [UserController::class, 'index13'])->name('bumil-tpk');
Route::get('/catin-tpk', [UserController::class, 'index14'])->name('catin-tpk');
Route::get('/pasca-persalinan-tpk', [UserController::class, 'index15'])->name('pasca-persalinan-tpk');

Route::resource('bdtpk', BdtpkController::class);
