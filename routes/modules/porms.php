<?php

use App\Http\Controllers\ProvincialOwnReceipt\ProvincialOwnReceiptController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'porms', 'as' => 'porms.', 'middleware' => ['can:manage,App\Models\ProvincialOwnReceipt']], function () {
    Route::get('/', [ProvincialOwnReceiptController::class, 'index'])->name('index')->can('view', App\Models\ProvincialOwnReceipt::class);
    Route::get('/all', [ProvincialOwnReceiptController::class, 'all'])->name('all')->can('viewAny', App\Models\ProvincialOwnReceipt::class);
    Route::get('/create', [ProvincialOwnReceiptController::class, 'create'])->name('create')->can('create', App\Models\ProvincialOwnReceipt::class);
    Route::get('/report', [ProvincialOwnReceiptController::class, 'report'])->name('report')->can('viewAny', App\Models\ProvincialOwnReceipt::class);
    Route::post('/', [ProvincialOwnReceiptController::class, 'store'])->name('store')->can('create', App\Models\ProvincialOwnReceipt::class);
    Route::get('/{ProvincialOwnReceipt}', [ProvincialOwnReceiptController::class, 'show'])->name('show')->can('view', 'ProvincialOwnReceipt');
    Route::get('/get/{ProvincialOwnReceipt}', [ProvincialOwnReceiptController::class, 'showDetail'])->name('detail')->can('view', 'ProvincialOwnReceipt');
    Route::patch('/update/field/{ProvincialOwnReceipt}', [ProvincialOwnReceiptController::class, 'updateField'])->name('updateField')->can('update', 'ProvincialOwnReceipt');
    Route::patch('/upload/file/{ProvincialOwnReceipt}', [ProvincialOwnReceiptController::class, 'uploadFile'])->name('uploadFile')->can('update', 'ProvincialOwnReceipt');
    Route::delete('/{ProvincialOwnReceipt}', [ProvincialOwnReceiptController::class, 'destroy'])->name('destroy')->can('delete', 'ProvincialOwnReceipt');
});
