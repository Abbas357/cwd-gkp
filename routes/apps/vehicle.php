<?php

use App\Models\Vehicle;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vehicle\HomeController;
use App\Http\Controllers\Vehicle\VehicleController;
use App\Http\Controllers\Vehicle\VehicleAllotmentController;

Route::group(['prefix' => 'vehicles', 'as' => 'vehicles.'], function () {

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [HomeController::class, 'settings'])->name('index')->can('viewSettings', App\Models\Vehicle::class);
        Route::post('/update', [HomeController::class, 'update'])->name('update')->can('updateSettings', App\Models\Vehicle::class);
        Route::post('/init', [HomeController::class, 'init'])->name('init')->can('initSettings', App\Models\Vehicle::class);
    });

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/all', [VehicleController::class, 'all'])->name('all')->can('viewAny', Vehicle::class);
    Route::get('/create', [VehicleController::class, 'create'])->name('create')->can('create', Vehicle::class);
    Route::get('/reports', [HomeController::class, 'reports'])->name('reports')->can('viewReports', Vehicle::class);
    Route::get('/search', [HomeController::class, 'search'])->name('search')->can('viewAny', Vehicle::class);
    Route::post('/', [VehicleController::class, 'store'])->name('store')->can('create', Vehicle::class);
    Route::get('/{vehicle}', [VehicleController::class, 'show'])->name('show')->can('view', 'vehicle');
    Route::get('/get/{vehicle}', [VehicleController::class, 'showDetail'])->name('detail')->can('view', 'vehicle');
    Route::get('/history/{vehicle}', [VehicleController::class, 'vehicleHistory'])->name('history')->can('viewHistory', 'vehicle');
    Route::patch('/update/field/{vehicle}', [VehicleController::class, 'updateField'])->name('updateField')->can('updateField', 'vehicle');
    Route::patch('/update/file/{vehicle}', [VehicleController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'vehicle');
    Route::get('/{vehicle}/details', [VehicleController::class, 'showVehicleDetails'])->name('details')->can('detail', 'vehicle');
    Route::delete('/{vehicle}', [VehicleController::class, 'destroy'])->name('destroy')->can('delete', 'vehicle');

    Route::prefix('allotment')->as('allotment.')->group(function () {
        Route::post('/', [VehicleAllotmentController::class, 'store'])->name('store')->can('create', App\Models\VehicleAllotment::class);
        Route::get('/{vehicle}', [VehicleAllotmentController::class, 'create'])->name('create')->can('create', App\Models\VehicleAllotment::class);
    });
});
