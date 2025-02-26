<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Module\VehicleController;
use App\Http\Controllers\Module\VehicleAllotmentController;

Route::prefix('vehicles')->as('vehicles.')->middleware(['can:manage vehicles'])->group(function () {
    Route::get('/', [VehicleController::class, 'index'])->name('index')->can('viewAny', App\Models\Vehicle::class);
    Route::get('/all', [VehicleController::class, 'all'])->name('all')->can('view', App\Models\Vehicle::class);
    Route::get('/create', [VehicleController::class, 'create'])->name('create')->can('create', App\Models\Vehicle::class);
    Route::get('/reports', [VehicleController::class, 'reports'])->name('reports')->can('view', 'vehicle');
    Route::get('/search', [VehicleController::class, 'search'])->name('search')->can('view', 'vehicle');
    Route::post('/', [VehicleController::class, 'store'])->name('store')->can('create', App\Models\Vehicle::class);
    Route::get('/{vehicle}', [VehicleController::class, 'show'])->name('show')->can('view', App\Models\Vehicle::class);
    Route::get('/get/{vehicle}', [VehicleController::class, 'showDetail'])->name('detail')->can('view', 'vehicle');
    Route::get('/history/{vehicle}', [VehicleController::class, 'vehicleHistory'])->name('history')->can('view', 'vehicle');
    Route::patch('/update/field/{vehicle}', [VehicleController::class, 'updateField'])->name('updateField')->can('update', 'vehicle');
    Route::delete('/{vehicle}', [VehicleController::class, 'destroy'])->name('destroy')->can('delete', 'vehicle');

    Route::prefix('allotment')->as('allotment.')->group(function () {
        Route::get('/{vehicle}', [VehicleAllotmentController::class, 'create'])->name('create')->can('view', 'allotment');
        Route::post('', [VehicleAllotmentController::class, 'store'])->name('store')->can('view', 'allotment');
        Route::delete('/{allotment}', [VehicleAllotmentController::class, 'delete'])->name('delete')->can('delete', 'allotment');
    });
});
