<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BadutaController;
use App\Http\Controllers\PasperController;
use App\Http\Controllers\CatinController;

// Homepage
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Dashboard (authenticated & verified)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Simpan logo
Route::post('/store-logo', [SettingController::class, 'store'])->name('store.logo');

// Tambahan route
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

// Admin Pages
Route::get('/population_data', [UserController::class, 'index1'])->name('population_data');
Route::get('/stunting', [UserController::class, 'index2'])->name('stunting');
Route::get('/pandu-genre', [UserController::class, 'index3'])->name('pandu-genre');
Route::get('/baduta', [UserController::class, 'index4'])->name('baduta');
Route::get('/bumil', [UserController::class, 'index5'])->name('bumil');
Route::get('/catin', [UserController::class, 'index6'])->name('catin');
Route::get('/kinerja-tpk', [UserController::class, 'index8'])->name('kinerja-tpk');
Route::get('/manajemen-user', [UserController::class, 'index9'])->name('manajemen-user');

// TPK Pages
Route::get('/stunting-tpk', [UserController::class, 'index12'])->name('stunting-tpk');
Route::get('/bumil-tpk', [UserController::class, 'index13'])->name('bumil-tpk');
Route::get('/catin-tpk', [UserController::class, 'index14'])->name('catin-tpk');

// Manajemen Penduduk
Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');

// Baduta CRUD
Route::resource('baduta', BadutaController::class);
Route::get('/baduta', [BadutaController::class, 'index'])->name('baduta.index');
Route::get('/baduta/{id}', [BadutaController::class, 'show'])->name('baduta-detail');
Route::get('/baduta/{id}', [BadutaController::class, 'show'])->name('baduta.show');




// PASPER CRUD
Route::get('/pasper', [PasperController::class, 'index'])->name('pasper.index');
Route::get('/pasper/create', [PasperController::class, 'create'])->name('pasper.create');
Route::post('/pasper', [PasperController::class, 'store'])->name('pasper.store');

// CATIN CRUD
Route::get('/catin', [CatinController::class, 'index'])->name('catin.index');
Route::get('/catin/create', [CatinController::class, 'create'])->name('catin.create');
Route::post('/catin', [CatinController::class, 'store'])->name('catin.store');
Route::get('/catin/create/{penduduk_id}', [CatinController::class, 'create'])->name('catin.create');

// Form Static Rendering (jika masih dibutuhkan untuk shortcut saja)
Route::get('/bumil/create', fn () => Inertia::render('bumil/Create'))->name('bumil.create');

// Cek nama ibu berdasarkan NIK
Route::get('/cek-ibu/{nik}', [PendudukController::class, 'searchIbu'])->name('cek-ibu');
Route::post('/cek-nik', [PendudukController::class, 'cekNIK'])->name('cek-nik');
