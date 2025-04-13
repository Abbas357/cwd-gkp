<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dtms\DamageController;
use App\Http\Controllers\Dtms\InfrastructureController;
use App\Http\Controllers\Dtms\HomeController;
use App\Http\Controllers\Dtms\ReportController;

Route::prefix('dtms')->as('dtms.')->middleware(['can:manage dtms'])->group(function () {

    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [HomeController::class, 'settings'])->name('index');
        Route::post('/update', [HomeController::class, 'update'])->name('update');
        Route::post('/init', [HomeController::class, 'init'])->name('init');
    });

    Route::prefix('infrastructures')->as('infrastructures.')->group(function () {
        Route::get('/', [InfrastructureController::class, 'index'])->name('index')->can('viewAny', App\Models\Infrastructure::class);
        Route::get('/create', [InfrastructureController::class, 'create'])->name('create')->can('create', App\Models\Infrastructure::class);
        Route::get('/api', [InfrastructureController::class, 'infrastructures'])->name('api')->withoutMiddleware(['can:manage dts']);
        Route::post('/', [InfrastructureController::class, 'store'])->name('store')->can('create', App\Models\Infrastructure::class);
        Route::get('/{infrastructure}', [InfrastructureController::class, 'show'])->name('show')->can('view', 'infrastructure');
        Route::get('/get/{infrastructure}', [InfrastructureController::class, 'showDetail'])->name('detail')->can('view', 'infrastructure');
        Route::patch('/update/field/{infrastructure}', [InfrastructureController::class, 'updateField'])->name('updateField')->can('update', 'infrastructure');
        Route::delete('/{infrastructure}', [InfrastructureController::class, 'destroy'])->name('destroy')->can('delete', 'infrastructure');
    });

    Route::prefix('damages')->as('damages.')->group(function () {
        Route::get('/', [DamageController::class, 'index'])->name('index')->can('viewAny', App\Models\Damage::class);
        Route::get('/create', [DamageController::class, 'create'])->name('create')->can('create', App\Models\Damage::class);
        Route::post('/', [DamageController::class, 'store'])->name('store')->can('create', App\Models\Damage::class);
        Route::get('/{damage}', [DamageController::class, 'show'])->name('show')->can('view', 'damage');
        Route::get('/get/{damage}', [DamageController::class, 'showDetail'])->name('detail')->can('view', 'damage');
        Route::patch('/update/field/{damage}', [DamageController::class, 'updateField'])->name('updateField')->can('update', 'damage');
        Route::delete('/{damage}', [DamageController::class, 'destroy'])->name('destroy')->can('delete', 'damage');
    });

    Route::prefix('reports')->as('reports.')->group(function () { 
        Route::get('/', [ReportController::class, 'index'])->name('index')->can('view', App\Models\Damage::class);
        Route::get('/officer-wise', [ReportController::class, 'officerReport'])->name('officer-wise');
        Route::get('/district-wise', [ReportController::class, 'districtDamagesReport'])->name('district-wise'); 
        Route::get('/active-officers', [ReportController::class, 'activeOfficersReport'])->name('active-officers'); 
    });

});