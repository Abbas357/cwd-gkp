<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dts\DamageController;
use App\Http\Controllers\Dts\InfrastructureController;


Route::prefix('dts')->as('dts.')->middleware(['can:manage dts'])->group(function () {

    Route::get('/', [DamageController::class, 'index'])->name('index');

    Route::prefix('infrastructures')->as('infrastructures.')->group(function () {
        Route::get('/', [InfrastructureController::class, 'index'])->name('index')->can('viewAny', App\Models\Infrastructure::class);
        Route::get('/create', [InfrastructureController::class, 'create'])->name('create')->can('create', App\Models\Infrastructure::class);
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
    
});

