<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dmis\HomeController;
use App\Http\Controllers\Dmis\DamageController;
use App\Http\Controllers\Dmis\ReportController;
use App\Http\Controllers\dmis\DamageLogController;
use App\Http\Controllers\Dmis\InfrastructureController;

Route::prefix('dmis')->as('dmis.')->group(function () {

    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [HomeController::class, 'settings'])->name('index')->can('viewDmisSettings', App\Models\Setting::class);
        Route::post('/update', [HomeController::class, 'update'])->name('update')->can('updateDmisSettings', App\Models\Setting::class);
        Route::post('/init', [HomeController::class, 'init'])->name('init')->can('initDmisSettings', App\Models\Setting::class);
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
        Route::patch('/update/field/{damage}', [DamageController::class, 'updateField'])->name('updateField')->can('updateField', 'damage');
        Route::delete('/{damage}', [DamageController::class, 'destroy'])->name('destroy')->can('delete', 'damage');
        Route::get('/{damage}/logs', [DamageLogController::class, 'getLogs'])->name('logs');
    });

    Route::prefix('reports')->as('reports.')->group(function () { 
        Route::get('/', [ReportController::class, 'index'])->name('index')->can('viewMainReport', App\Models\Damage::class);
        Route::get('/officer-wise', [ReportController::class, 'officerReport'])->name('officer-wise')->can('viewOfficerWiseReport', App\Models\Damage::class);
        Route::get('/district-wise', [ReportController::class, 'districtDamagesReport'])->name('district-wise')->can('viewDistrictWiseReport', App\Models\Damage::class);
        Route::get('/active-officers', [ReportController::class, 'activeOfficersReport'])->name('active-officers')->can('viewActiveOfficerReport', App\Models\Damage::class);
    });
});