<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BadutaController;
use App\Http\Controllers\PasperController;
use App\Http\Controllers\CatinController;
use App\Http\Controllers\BumilController;

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

// ========== Admin Pages ==========
Route::get('/population_data', [UserController::class, 'index1'])->name('population_data');
Route::get('/stunting', [UserController::class, 'index2'])->name('stunting');
Route::get('/pandu-genre', [UserController::class, 'index3'])->name('pandu-genre');
Route::get('/baduta', [UserController::class, 'index4'])->name('baduta');
Route::get('/bumil', [UserController::class, 'index5'])->name('bumil');
Route::get('/catin', [UserController::class, 'index6'])->name('catin');
Route::get('/pasca-persalinan', [UserController::class, 'index7'])->name('pasca-persalinan');
Route::get('/kinerja-tpk', [UserController::class, 'index8'])->name('kinerja-tpk');
Route::get('/manajemen-user', [UserController::class, 'index9'])->name('manajemen-user');


// ========== TPK Pages ==========
Route::get('/stunting-tpk', [UserController::class, 'index12'])->name('stunting-tpk');
Route::get('/baduta_tpk', [UserController::class, 'index10'])->name('baduta_tpk');
Route::get('/bumil-tpk', [UserController::class, 'index13'])->name('bumil-tpk');
Route::get('/catin-tpk', [UserController::class, 'index14'])->name('catin-tpk');
Route::get('/pasca-persalinan-tpk', [UserController::class, 'index15'])->name('pasca-persalinan-tpk');
Route::get('/population_data_tpk', [UserController::class, 'index11'])->name('population_data_tpk');

// Manajemen Penduduk
Route::resource('penduduk', PendudukController::class);
Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
Route::get('/Penduduk/Index', [PendudukController::class, 'index']);
Route::get('/penduduk/{nik}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
Route::put('/penduduk/{nik}', [PendudukController::class, 'update'])->name('penduduk.update');
Route::delete('/penduduk/{nik}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');


// BADUTA CRUD
Route::resource('baduta', BadutaController::class);
Route::get('/baduta', [BadutaController::class, 'index'])->name('baduta.index');
Route::get('/baduta/create', [BadutaController::class, 'create'])->name('baduta.create');
Route::post('/baduta', [BadutaController::class, 'store'])->name('baduta.store');
Route::get('/Baduta/Index', [BadutaController::class, 'index']);
Route::delete('/baduta/{nik}', [BadutaController::class, 'destroy'])->name('baduta.destroy');
Route::get('/baduta/{nik}', [BadutaController::class, 'show'])->name('baduta.show');
Route::delete('/baduta/{nik}', [BadutaController::class, 'destroy'])->name('baduta.destroy');

// PASPER CRUD
Route::resource('pasper', PasperController::class);
Route::get('/pasper', [PasperController::class, 'index'])->name('pasper.index');
Route::get('/pasper/create', [PasperController::class, 'create'])->name('pasper.create');
Route::post('/pasper', [PasperController::class, 'store'])->name('pasper.store');
Route::get('/Pasper/Index', [PasperController::class, 'index']);
Route::get('/pasper/{nik}', [PasperController::class, 'show'])->name('pasper.show');
Route::delete('/pasper/{nik}', [PasperController::class, 'destroy'])->name('pasper.destroy');

// CATIN CRUD
Route::get('/catin', [CatinController::class, 'index'])->name('catin.index');
Route::get('/catin/create', [CatinController::class, 'create'])->name('catin.create');
Route::post('/catin', [CatinController::class, 'store'])->name('catin.store');

//BUMIL CRUD
Route::resource('bumil', BumilController::class);
Route::get('/bumil', [BumilController::class, 'index'])->name('bumil.index');
Route::get('/bumil/create', [BumilController::class, 'create'])->name('bumil.create');
Route::post('/bumil', [BumilController::class, 'store'])->name('bumil.store');
Route::get('/Bumil/Index', [BumilController::class, 'index']);
Route::get('/bumil/{nik}', [BumilController::class, 'show'])->name('bumil.show');
Route::delete('/bumil/{nik}', [BumilController::class, 'destroy'])->name('bumil.destroy');

// Cek nama ibu berdasarkan NIK
Route::get('/cek-ibu/{nik}', [PendudukController::class, 'searchIbu'])->name('cek-ibu');
Route::post('/cek-nik', [PendudukController::class, 'cekNIK'])->name('cek-nik');


// Form Static Rendering (jika masih dibutuhkan untuk shortcut saja)
// Route::get('/bumil/create', fn () => Inertia::render('bumil/Create'))->name('bumil.create');

// Route::get('/baduta', [PendudukController::class, 'index'])->name('baduta.index');
// Route::get('/baduata/create', [PendudukController::class, 'create'])->name('baduta.create');
// Route::post('/baduta', [PendudukController::class, 'store'])->name('baduta.store');
// Route::get('/baduta', [BadutaController::class, 'index'])->name('baduta.index');
// Route::get('/baduta/create', [BadutaController::class, 'create'])->name('baduta.create');
// Route::post('/baduta', [BadutaController::class, 'store'])->name('baduta.store');
// Route::get('/baduta/{id}/edit', [BadutaController::class, 'edit'])->name('baduta.edit');
// Route::put('/baduta/{id}', [BadutaController::class, 'update'])->name('baduta.update');
// Route::delete('/baduta/{id}', [BadutaController::class, 'destroy'])->name('baduta.destroy');
