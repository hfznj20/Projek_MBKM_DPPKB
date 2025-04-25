<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// use App\Http\Controllers\SettingController;

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
