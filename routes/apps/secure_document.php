<?php

use App\Http\Controllers\SecureDocument\SecureDocumentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'documents', 'as' => 'documents.'], function () {
    Route::get('/', [SecureDocumentController::class, 'index'])->name('index')->can('viewAny', App\Models\SecureDocument::class);
    Route::get('/create', [SecureDocumentController::class, 'create'])->name('create')->can('create', App\Models\SecureDocument::class);
    Route::post('/', [SecureDocumentController::class, 'store'])->name('store')->can('create', App\Models\SecureDocument::class);
    Route::get('/{document}', [SecureDocumentController::class, 'show'])->name('show')->can('view', 'document');
    Route::get('/get/{document}', [SecureDocumentController::class, 'viewQR'])->name('view')->can('view', 'document');
    Route::patch('/update/field/{document}', [SecureDocumentController::class, 'updateField'])->name('updateField')->can('updateField', 'document');
    Route::delete('/{document}', [SecureDocumentController::class, 'destroy'])->name('destroy')->can('delete', 'document');
});
