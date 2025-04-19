<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Standardization\ProductController;
use App\Http\Controllers\Standardization\StandardizationController;

Route::prefix('standardizations')->as('standardizations.')->group(function () {
    Route::get('/', [StandardizationController::class, 'index'])->name('index')->can('viewAny', App\Models\Standardization::class);
    Route::patch('/approve/{standardization}', [StandardizationController::class, 'approve'])->name('approve')->can('approve', 'standardization');
    Route::patch('/reject/{standardization}', [StandardizationController::class, 'reject'])->name('reject')->can('reject', 'standardization');
    Route::get('/{standardization}', [StandardizationController::class, 'show'])->name('show')->can('view', 'standardization');
    Route::get('/get/{standardization}', [StandardizationController::class, 'showDetail'])->name('detail')->can('detail', 'standardization');
    Route::get('/card/{standardization}', [StandardizationController::class, 'showCard'])->name('card')->can('viewCard', 'standardization');
    Route::patch('/renew/{standardization}', [StandardizationController::class, 'renew'])->name('renew')->can('renew', 'standardization');
    Route::patch('/update/field/{standardization}', [StandardizationController::class, 'updateField'])->name('updateField')->can('updateField', 'standardization');
    Route::patch('/upload/file/{standardization}', [StandardizationController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'standardization');

    Route::prefix('product')->as('product.')->group(function () {
        Route::get('/{Standardization}', [ProductController::class, 'detail'])->name('detail')->can('viewAny', App\Models\Product::class);
        Route::post('/{id}/update', [ProductController::class, 'update'])->name('update')->can('update', App\Models\Product::class);
        Route::patch('/{id}/upload', [ProductController::class, 'upload'])->name('upload')->can('upload', App\Models\Product::class);
        Route::delete('{id}', [ProductController::class, 'destroy'])->name('destroy')->can('delete', App\Models\Product::class);
    });
});
