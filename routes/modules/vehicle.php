<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vehicle\VehicleController;
use App\Http\Controllers\Vehicle\VehicleAllotmentController;

use App\Models\Vehicle;

Route::group(['prefix' => 'vehicles', 'as' => 'vehicles.', 'middleware' => ['can:manage,App\Models\Vehicle']], function () {
    Route::get('/', [VehicleController::class, 'index'])->name('index')->can('viewAny', Vehicle::class);
    Route::get('/all', [VehicleController::class, 'all'])->name('all')->can('viewAny', Vehicle::class);
    Route::get('/create', [VehicleController::class, 'create'])->name('create')->can('create', Vehicle::class);
    Route::get('/reports', [VehicleController::class, 'reports'])->name('reports')->can('viewAny', Vehicle::class);
    Route::get('/search', [VehicleController::class, 'search'])->name('search')->can('viewAny', Vehicle::class);
    Route::post('/', [VehicleController::class, 'store'])->name('store')->can('create', Vehicle::class);
    Route::get('/{vehicle}', [VehicleController::class, 'show'])->name('show')->can('view', 'vehicle');
    Route::get('/get/{vehicle}', [VehicleController::class, 'showDetail'])->name('detail')->can('detail', 'vehicle');
    Route::get('/history/{vehicle}', [VehicleController::class, 'vehicleHistory'])->name('history')->can('history', 'vehicle');
    Route::patch('/update/field/{vehicle}', [VehicleController::class, 'updateField'])->name('updateField')->can('update-field', 'vehicle');
    Route::patch('/update/file/{vehicle}', [VehicleController::class, 'uploadFile'])->name('uploadFile')->can('update-file', 'Contractor');
    Route::delete('/{vehicle}', [VehicleController::class, 'destroy'])->name('destroy')->can('delete', 'vehicle');
    Route::get('/{vehicle}/details', [VehicleController::class, 'showVehicleDetails'])->name('details')->can('detail', 'vehicle');

    Route::prefix('allotment')->as('allotment.')->group(function () {
        Route::get('/{vehicle}', [VehicleAllotmentController::class, 'create'])->name('create');
        Route::post('', [VehicleAllotmentController::class, 'store'])->name('store');
        Route::delete('/{allotment}', [VehicleAllotmentController::class, 'delete'])->name('delete');
    });
});
