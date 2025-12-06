<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\SpkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('spk.index');
});

// Grouping Route untuk SPK dengan prefix 'spk'
Route::prefix('spk')->name('spk.')->group(function () {
    // Dashboard
    Route::get('/', [SpkController::class, 'index'])->name('index');

    // Data Master
    Route::get('/kriteria', [SpkController::class, 'criteria'])->name('criteria');

    Route::get('/alternatif', [AlternativeController::class, 'alternatives'])->name('alternatives');
    Route::get('/alternatif/tambah', [AlternativeController::class, 'createAlternative'])->name('alternatives.create');
    Route::post('/alternatif', [AlternativeController::class, 'storeAlternative'])->name('alternatives.store');
    Route::get('/alternatif/{id}/edit', [AlternativeController::class, 'editAlternative'])->name('alternatives.edit');
    Route::put('/alternatif/{id}', [AlternativeController::class, 'updateAlternative'])->name('alternatives.update');
    Route::delete('/alternatif/{id}', [AlternativeController::class, 'destroyAlternative'])->name('alternatives.destroy');

    // Menu Analisa (Input Data Matrix)
    Route::get('/analisa', [SpkController::class, 'analysis'])->name('analysis');
    Route::post('/analisa', [SpkController::class, 'storeAnalysis'])->name('storeAnalysis');

    // Menu Perhitungan (Hasil Akhir)
    Route::get('/perhitungan', [SpkController::class, 'calculation'])->name('calculation');
});
