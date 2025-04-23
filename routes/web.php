<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SettingController;
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/store-logo', [SettingController::class, 'store'])->name('store.logo');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
