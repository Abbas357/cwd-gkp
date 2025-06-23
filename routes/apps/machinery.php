<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Machinery\HomeController;
use App\Http\Controllers\Machinery\MachineryController;
use App\Http\Controllers\Machinery\MachineryAllocationController;

Route::group(['prefix' => 'machineries', 'as' => 'machineries.'], function () {
    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [HomeController::class, 'settings'])->name('index')->can('viewSettings', App\Models\Machinery::class);
        Route::post('/update', [HomeController::class, 'update'])->name('update')->can('updateSettings', App\Models\Machinery::class);
        Route::post('/init', [HomeController::class, 'init'])->name('init')->can('initSettings', App\Models\Machinery::class);
    });

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/all', [MachineryController::class, 'all'])->name('all')->can('viewAny', App\Models\Machinery::class);
    Route::get('/create', [MachineryController::class, 'create'])->name('create')->can('create', App\Models\Machinery::class);
    Route::get('/report', [HomeController::class, 'reports'])->name('reports')->can('viewReports', App\Models\Machinery::class);
    Route::get('/search', [MachineryController::class, 'search'])->name('search')->can('viewAny', App\Models\Machinery::class);
    Route::post('/', [MachineryController::class, 'store'])->name('store')->can('create', App\Models\Machinery::class);
    Route::get('/{machinery}', [MachineryController::class, 'show'])->name('show')->can('view', 'machinery');
    Route::get('/get/{machinery}', [MachineryController::class, 'showDetail'])->name('detail')->can('view', 'machinery');
    Route::get('/{machinery}/details', [MachineryController::class, 'showMachineDetails'])->name('details')->can('detail', 'machinery');
    Route::get('/history/{machinery}', [MachineryController::class, 'machineryHistory'])->name('history')->can('viewHistory', 'machinery');
    Route::patch('/update/field/{machinery}', [MachineryController::class, 'updateField'])->name('updateField')->can('updateField', 'machinery');
    Route::patch('/upload/file/{machinery}', [MachineryController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'machinery');
    Route::delete('/{machinery}', [MachineryController::class, 'destroy'])->name('destroy')->can('delete', 'machinery');
    Route::get('/search', [MachineryController::class, 'search'])->name('search')->can('viewAny', App\Models\Machinery::class);
    Route::get('/filter-options', [MachineryController::class, 'getFilterOptions'])->name('filter-options')->can('viewAny', App\Models\Machinery::class);

    Route::prefix('allocation')->as('allocation.')->group(function () {
        Route::get('/{machinery}', [MachineryAllocationController::class, 'create'])->name('create')->can('create', App\Models\MachineryAllocation::class);
        Route::post('/', [MachineryAllocationController::class, 'store'])->name('store')->can('create', App\Models\MachineryAllocation::class);
    });
});
