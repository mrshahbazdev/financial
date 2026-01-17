<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/simulator', [\App\Http\Controllers\SimulatorController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('simulator');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('analyses/{analysis}/pdf', [\App\Http\Controllers\AnalysisController::class, 'downloadPdf'])->name('analyses.pdf');
    Route::resource('analyses', \App\Http\Controllers\AnalysisController::class);
    Route::resource('taps', \App\Http\Controllers\TapController::class);
});

require __DIR__ . '/auth.php';
