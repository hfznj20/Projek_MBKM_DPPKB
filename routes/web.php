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
use App\Http\Controllers\PandugenreController;

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
//Manajemen User TPK
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

//Pandu Genre
Route::resource('pandugenre', PandugenreController::class);
Route::get('/pandu-genre', [PandugenreController::class, 'index'])->name('pandugenre.index');
Route::get('/pandu-genre/create', [PandugenreController::class, 'create'])->name('pandugenre.create');
Route::get('/check-baduta/{nik}', [PandugenreController::class, 'checkBaduta']);
Route::post('/pandu-genre', [PandugenreController::class, 'store'])->name('pandugenre.store');
Route::delete('/pandu-genre/{nik}', [PandugenreController::class, 'destroy'])->name('pandu-genre.destroy');
Route::get('/pandu-genre/{nik}', [PandugenreController::class, 'show'])->name('pandu-genre.show');
//kunjungan
Route::get('/pandu-genre/{nik}/kunjungan/create', [PandugenreController::class, 'createKunjungan']);
Route::post('/pandu-genre/kunjungan', [PanduGenreController::class, 'storeKunjungan']);
Route::get('/pandu-genre/{nik}/kunjungan/{id}', [PanduGenreController::class, 'showKunjungan']);

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


// BADUTA CRUD
Route::resource('baduta', BadutaController::class);
Route::get('/baduta', [BadutaController::class, 'index'])->name('baduta.index');
Route::get('/baduta/create', [BadutaController::class, 'create'])->name('baduta.create');
Route::post('/baduta', [BadutaController::class, 'store'])->name('baduta.store');
Route::get('/Baduta/Index', [BadutaController::class, 'index']);
Route::delete('/baduta/{nik}', [BadutaController::class, 'destroy'])->name('baduta.destroy');
Route::get('/baduta/{nik}', [BadutaController::class, 'show'])->name('baduta.show');

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
