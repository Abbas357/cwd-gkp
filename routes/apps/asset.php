<?php

use App\Models\Asset;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset\HomeController;
use App\Http\Controllers\Asset\AssetController;
use App\Http\Controllers\Asset\AssetAllotmentController;

Route::group(['prefix' => 'vehicles', 'as' => 'vehicles.'], function () {

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [HomeController::class, 'settings'])->name('index')->can('viewAssetSettings', App\Models\Setting::class);
        Route::post('/update', [HomeController::class, 'update'])->name('update')->can('updateAssetSettings', App\Models\Setting::class);
        Route::post('/init', [HomeController::class, 'init'])->name('init')->can('initAssetSettings', App\Models\Setting::class);
    });

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/all', [AssetController::class, 'all'])->name('all')->can('viewAny', Asset::class);
    Route::get('/create', [AssetController::class, 'create'])->name('create')->can('create', Asset::class);
    Route::get('/reports', [HomeController::class, 'reports'])->name('reports')->can('viewReports', Asset::class);
    Route::get('/search', [HomeController::class, 'search'])->name('search')->can('viewAny', Asset::class);
    Route::post('/', [AssetController::class, 'store'])->name('store')->can('create', Asset::class);
    Route::get('/{asset}', [AssetController::class, 'show'])->name('show')->can('view', 'vehicle');
    Route::get('/get/{asset}', [AssetController::class, 'showDetail'])->name('detail')->can('view', 'vehicle');
    Route::get('/history/{asset}', [AssetController::class, 'vehicleHistory'])->name('history')->can('viewHistory', 'vehicle');
    Route::patch('/update/field/{asset}', [AssetController::class, 'updateField'])->name('updateField')->can('updateField', 'vehicle');
    Route::patch('/update/file/{asset}', [AssetController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'vehicle');
    Route::get('/{asset}/details', [AssetController::class, 'showAssetDetails'])->name('details')->can('detail', 'vehicle');
    Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('destroy')->can('delete', 'vehicle');

    Route::prefix('allotment')->as('allotment.')->group(function () {
        Route::post('/', [AssetAllotmentController::class, 'store'])->name('store')->can('create', App\Models\AssetAllotment::class);
        Route::get('/{asset}', [AssetAllotmentController::class, 'create'])->name('create')->can('create', App\Models\AssetAllotment::class);
    });
});
