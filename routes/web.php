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
use App\Http\Controllers\ManajemenController;

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
// Route::get('/population_data', [UserController::class, 'indexPenduduk'])->name('population_data');
// Route::get('/stunting-admin', [UserController::class, 'indexStunting'])->name('stunting-admin');
Route::get('/pandu-genre', [UserController::class, 'index3'])->name('pandu-genre');

Route::get('/baduta', [UserController::class, 'index4'])->name('baduta');
Route::get('/bumil', [UserController::class, 'index5'])->name('bumil');
Route::get('/catin', [UserController::class, 'index6'])->name('catin');
Route::get('/pasca-persalinan', [UserController::class, 'index7'])->name('pasca-persalinan');
Route::get('/kinerja-tpk', [UserController::class, 'index8'])->name('kinerja-tpk');


// Route::get('/bayi', [UserController::class, 'indexBaduta'])->name('bayi');
// Route::get('/ibu', [UserController::class, 'indexBumil'])->name('ibu');
// Route::get('/calon-pengantin', [UserController::class, 'indexCatin'])->name('calon-pengantin');
// Route::get('/pasca-persalinan', [UserController::class, 'indexPascaPersalinan'])->name('pasca-persalinan');
// Route::get('/kinerja-tpk', [UserController::class, 'indexKinerjaTPK'])->name('kinerja-tpk');

Route::resource('manajemen', ManajemenController::class)
    ->parameters(['manajemen' => 'NIK'])
    ->names([
        'index' => 'manajemen.index',
        'create' => 'manajemen.create',
        'store' => 'manajemen.store',
        'edit' => 'manajemen.edit',
        'update' => 'manajemen.update',
        'destroy' => 'manajemen.destroy',

    ]);
Route::get('/manajemen/{NIK}', [ManajemenController::class, 'show'])->name('manajemen.show');

// ========== TPK Pages ==========
Route::get('/stunting-tpk', [UserController::class, 'indexStuntingTPK'])->name('stunting-tpk');

// Manajemen Penduduk
Route::resource('penduduk', PendudukController::class);
Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
Route::get('/Penduduk/Index', [PendudukController::class, 'index']);
Route::get('/penduduk/{nik}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
Route::put('/penduduk/{nik}', [PendudukController::class, 'update'])->name('penduduk.update');
Route::delete('/penduduk/{nik}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');
Route::get('/penduduk/export/pdf', [PendudukController::class, 'exportPdf'])->name('penduduk.export.pdf');
Route::get('/penduduk/export/excel', [PendudukController::class, 'exportExcel'])->name('penduduk.export.excel');


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
Route::resource('catin', CatinController::class);
Route::get('/catin', [CatinController::class, 'index'])->name('catin.index');
Route::get('/catin/create', [CatinController::class, 'create'])->name('catin.create');
Route::post('/catin', [CatinController::class, 'store'])->name('catin.store');
Route::post('/catin/storePasanganBaru', [CatinController::class, 'storePasanganBaru']);
Route::get('/Catin/Index', [CatinController::class, 'index']);
Route::get('/catin/{nik}', [CatinController::class, 'show'])->name('catin.show');
Route::delete('/catin/{nik}', [CatinController::class, 'destroy'])->name('catin.destroy');

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

