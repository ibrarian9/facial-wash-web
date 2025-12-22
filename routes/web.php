<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\SpkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->prefix('spk')->name('spk.')->group(function () {

    Route::get('/', [SpkController::class, 'index'])->name('index');

    Route::middleware('role:admin')->group(function () {

        // A. CRUD DATA KRITERIA
        Route::get('/kriteria', [CriteriaController::class, 'criteria'])->name('criteria');
        Route::get('/kriteria/tambah', [CriteriaController::class, 'criteriaCreate'])->name('criteria.create');
        Route::post('/kriteria', [CriteriaController::class, 'criteriaStore'])->name('criteria.store');
        Route::get('/kriteria/{id}/edit', [CriteriaController::class, 'criteriaEdit'])->name('criteria.edit');
        Route::put('/kriteria/{id}', [CriteriaController::class, 'criteriaUpdate'])->name('criteria.update');
        Route::delete('/kriteria/{id}', [CriteriaController::class, 'criteriaDestroy'])->name('criteria.destroy');

        // B. CRUD DATA ALTERNATIF (PRODUK)
        Route::get('/alternatif', [AlternativeController::class, 'alternatives'])->name('alternatives');
        Route::get('/alternatif/tambah', [AlternativeController::class, 'createAlternative'])->name('alternatives.create');
        Route::post('/alternatif', [AlternativeController::class, 'storeAlternative'])->name('alternatives.store');
        Route::get('/alternatif/{id}/edit', [AlternativeController::class, 'editAlternative'])->name('alternatives.edit');
        Route::put('/alternatif/{id}', [AlternativeController::class, 'updateAlternative'])->name('alternatives.update');
        Route::delete('/alternatif/{id}', [AlternativeController::class, 'destroyAlternative'])->name('alternatives.destroy');

        // C. INPUT NILAI MATRIKS (DATA FAKTA ADMIN)
        // Admin mengisi harga asli, kandungan, dll (Data Statis)
        Route::get('/analisa-admin', [SpkController::class, 'analysis'])->name('analysis');
        Route::post('/analisa-admin', [SpkController::class, 'storeAnalysis'])->name('storeAnalysis');
        Route::post('/analisa-admin/reset', [SpkController::class, 'resetAnalysis'])->name('resetAnalysis');

        // D. PERHITUNGAN MASTER (VIEW ADMIN)
        Route::get('/perhitungan-master', [SpkController::class, 'calculation'])->name('calculation');
        Route::get('/laporan-rekomendasi', [SpkController::class, 'report'])->name('report');
        Route::get('/laporan-responden', [SpkController::class, 'responden'])->name('responden');
        Route::get('/laporan-responden/{id}', [SpkController::class, 'respondenDetail'])->name('respondenDetail');
    });

    Route::middleware('role:user')->group(function () {

        Route::get('/cari-rekomendasi', [RecommendationController::class, 'index'])->name('recommendation');
        Route::post('/cari-rekomendasi/proses', [RecommendationController::class, 'process'])->name('recommendation.process');
    });
});
