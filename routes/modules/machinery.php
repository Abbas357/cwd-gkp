<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Machinery\MachineryController;
use App\Http\Controllers\Machinery\MachineryAllocationController;

Route::group(['prefix' => 'machineries', 'as' => 'machineries.', 'middleware' => ['can:manage,App\Models\Machinery']], function () {
    Route::get('/', [MachineryController::class, 'index'])->name('index')->can('view', App\Models\Machinery::class);
    Route::get('/all', [MachineryController::class, 'all'])->name('all')->can('viewAny', App\Models\Machinery::class);
    Route::get('/create', [MachineryController::class, 'create'])->name('create')->can('create', App\Models\Machinery::class);
    Route::get('/report', [MachineryController::class, 'reports'])->name('reports')->can('viewAny', App\Models\Machinery::class);
    Route::get('/search', [MachineryController::class, 'search'])->name('search')->can('viewAny', App\Models\Machinery::class);
    Route::post('/', [MachineryController::class, 'store'])->name('store')->can('create', App\Models\Machinery::class);
    Route::get('/{Machinery}', [MachineryController::class, 'show'])->name('show')->can('view', 'Machinery');
    Route::get('/get/{Machinery}', [MachineryController::class, 'showDetail'])->name('detail')->can('view', 'Machinery');
    Route::get('/history/{vehicle}', [MachineryController::class, 'machineryHistory'])->name('history')->can('view', 'Machinery');
    Route::patch('/update/field/{Machinery}', [MachineryController::class, 'updateField'])->name('updateField')->can('update', 'Machinery');
    Route::patch('/upload/file/{Machinery}', [MachineryController::class, 'uploadFile'])->name('uploadFile')->can('update', 'Machinery');
    Route::delete('/{Machinery}', [MachineryController::class, 'destroy'])->name('destroy')->can('delete', 'Machinery');

    Route::prefix('allocation')->as('allocation.')->group(function () {
        Route::get('/{Machinery}', [MachineryAllocationController::class, 'create'])->name('create');
        Route::post('', [MachineryAllocationController::class, 'store'])->name('store');
        Route::delete('/{allocation}', [MachineryAllocationController::class, 'delete'])->name('delete');
    });
});
