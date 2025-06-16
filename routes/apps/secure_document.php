<?php

use App\Http\Controllers\SecureDocument\SecureDocumentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'documents', 'as' => 'documents.'], function () {
    Route::get('/', [SecureDocumentController::class, 'index'])->name('index')->can('viewAny', App\Models\SecureDocument::class);
    Route::get('/create', [SecureDocumentController::class, 'create'])->name('create')->can('create', App\Models\SecureDocument::class);
    Route::post('/', [SecureDocumentController::class, 'store'])->name('store')->can('create', App\Models\SecureDocument::class);
    Route::get('/{document}', [SecureDocumentController::class, 'show'])->name('show')->can('view', 'document');
    Route::get('/get/{document}', [SecureDocumentController::class, 'showDetail'])->name('detail')->can('view', 'tender');
    Route::patch('/publish/{document}', [SecureDocumentController::class, 'publishDocument'])->name('publish')->can('publish', 'document');
    Route::patch('/archive/{document}', [SecureDocumentController::class, 'archiveDocument'])->name('archive')->can('archive', 'document');
    Route::get('/qr/{document}', [SecureDocumentController::class, 'viewQR'])->name('viewQR')->can('view', 'document');
    Route::patch('/update/field/{document}', [SecureDocumentController::class, 'updateField'])->name('updateField')->can('updateField', 'document');
    Route::patch('/upload/file/{document}', [SecureDocumentController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'document');
    Route::delete('/{document}', [SecureDocumentController::class, 'destroy'])->name('destroy')->can('delete', 'document');
});
