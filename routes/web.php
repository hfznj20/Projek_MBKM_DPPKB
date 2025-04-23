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

// Route untuk menyimpan logo
Route::post('/store-logo', [SettingController::class, 'store'])->name('store.logo');

// Route halaman Data Penduduk
Route::get('/population_data', function () {
    return Inertia::render('PopulationData');
})->name('population.data');

// === Halaman tambahan sesuai sidebar === //
Route::get('/stunting', function () {
    return Inertia::render('Stunting');
})->name('stunting');

Route::get('/pandu-genre', function () {
    return Inertia::render('PanduGenre');
})->name('pandu.genre');

Route::get('/baduta', function () {
    return Inertia::render('Baduta');
})->name('baduta');

Route::get('/bumil', function () {
    return Inertia::render('Bumil');
})->name('bumil');

Route::get('/catin', function () {
    return Inertia::render('Catin');
})->name('catin');

Route::get('/pasca-persalinan', function () {
    return Inertia::render('PascaPersalinan');
})->name('pasca.persalinan');

Route::get('/kinerja-tpk', function () {
    return Inertia::render('KinerjaTPK');
})->name('kinerja.tpk');

Route::get('/manajemen-user', function () {
    return Inertia::render('ManajemenUser');
})->name('manajemen.user');

// Route tambahan dari file lain
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
