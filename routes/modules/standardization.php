<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Module\ProductController;
use App\Http\Controllers\Module\StandardizationController;

Route::prefix('standardizations')->as('standardizations.')->middleware(['can:manage standardizations'])->group(function () {
    Route::get('/', [StandardizationController::class, 'index'])->name('index')->can('viewAny', App\Models\Standardization::class);
    Route::patch('/approve/{standardization}', [StandardizationController::class, 'approve'])->name('approve')->can('approve', 'Standardization');
    Route::patch('/reject/{standardization}', [StandardizationController::class, 'reject'])->name('reject')->can('reject', 'Standardization');
    Route::get('/{standardization}', [StandardizationController::class, 'show'])->name('show')->can('view', 'Standardization');
    Route::get('/get/{standardization}', [StandardizationController::class, 'showDetail'])->name('detail')->can('view', 'Standardization');
    Route::get('/card/{standardization}', [StandardizationController::class, 'showCard'])->name('card')->can('card', 'Standardization');
    Route::patch('/renew/{standardization}', [StandardizationController::class, 'renew'])->name('renew')->can('renew', 'Standardization');
    Route::patch('/update/field/{standardization}', [StandardizationController::class, 'updateField'])->name('updateField')->can('update', 'Standardization');
    Route::patch('/upload/file/{standardization}', [StandardizationController::class, 'uploadFile'])->name('uploadFile')->can('update', 'Standardization');

    Route::prefix('product')->as('product.')->group(function () {
        Route::get('/{Standardization}', [ProductController::class, 'detail'])->name('detail')->can('view', 'Product');
        Route::post('/{id}/update', [ProductController::class, 'update'])->name('update');
        Route::patch('/{id}/upload', [ProductController::class, 'upload'])->name('upload');
        Route::delete('{id}', [ProductController::class, 'destroy'])->name('destroy');
    });
});
