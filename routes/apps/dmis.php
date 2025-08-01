<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dmis\HomeController;
use App\Http\Controllers\Dmis\DamageController;
use App\Http\Controllers\Dmis\ReportController;
use App\Http\Controllers\Dmis\InfrastructureController;

Route::prefix('dmis')->as('dmis.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [HomeController::class, 'settings'])->name('index')->can('viewSettings', App\Models\Damage::class);
        Route::post('/update', [HomeController::class, 'update'])->name('update')->can('updateSettings', App\Models\Damage::class);
        Route::post('/init', [HomeController::class, 'init'])->name('init')->can('initSettings', App\Models\Damage::class);
    });

    Route::prefix('infrastructures')->as('infrastructures.')->group(function () {
        Route::get('/', [InfrastructureController::class, 'index'])->name('index')->can('viewAny', App\Models\Infrastructure::class);
        Route::get('/create', [InfrastructureController::class, 'create'])->name('create')->can('create', App\Models\Infrastructure::class);
        Route::get('/api', [InfrastructureController::class, 'infrastructures'])->name('api');
        Route::post('/', [InfrastructureController::class, 'store'])->name('store')->can('create', App\Models\Infrastructure::class);
        Route::get('/{infrastructure}', [InfrastructureController::class, 'show'])->name('show')->can('view', 'infrastructure');
        Route::get('/get/{infrastructure}', [InfrastructureController::class, 'showDetail'])->name('detail')->can('view', 'infrastructure');
        Route::patch('/update/field/{infrastructure}', [InfrastructureController::class, 'updateField'])->name('updateField')->can('updateField', 'infrastructure');
        Route::delete('/{infrastructure}', [InfrastructureController::class, 'destroy'])->name('destroy')->can('delete', 'infrastructure');
    });

    Route::prefix('damages')->as('damages.')->group(function () {
        Route::get('/', [DamageController::class, 'index'])->name('index')->can('viewAny', App\Models\Damage::class);
        Route::get('/create', [DamageController::class, 'create'])->name('create')->can('create', App\Models\Damage::class);
        Route::post('/', [DamageController::class, 'store'])->name('store')->can('create', App\Models\Damage::class);
        Route::get('/{damage}', [DamageController::class, 'show'])->name('show')->can('view', 'damage');
        Route::get('/get/{damage}', [DamageController::class, 'showDetail'])->name('detail')->can('view', 'damage');
        Route::get('/logs/{damage}', [DamageController::class, 'showLogs'])->name('logs')->can('view', 'damage');
        Route::patch('/update/field/{damage}', [DamageController::class, 'updateField'])->name('updateField')->can('updateField', 'damage');
        Route::post('/upload/file/{damage}', [DamageController::class, 'uploadFile'])->name('uploadFile')->can('updateField', 'damage');
        Route::delete('/{damage}', [DamageController::class, 'destroy'])->name('destroy')->can('delete', 'damage');
    });

    Route::prefix('reports')->as('reports.')->group(function () { 
        Route::get('/', [ReportController::class, 'index'])->name('index')->can('viewMainReport', App\Models\Damage::class);
        Route::post('/main', [ReportController::class, 'loadReport'])->name('loadReport')->can('viewMainReport', App\Models\Damage::class);
        Route::get('/district/{district}', [ReportController::class, 'districtDetailsReport'])->name('district-details')->can('viewDistrictWiseReport', App\Models\Damage::class);
    });
});