<?php

use App\Models\ServiceCard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceCard\ServiceCardController;
use App\Http\Controllers\ServiceCard\ServiceCardUserController;
use App\Http\Controllers\ServiceCard\ServiceCardActionController;

Route::prefix('service_cards')->as('service_cards.')->group(function () {
    Route::get('/', [ServiceCardController::class, 'index'])->name('index');
    Route::get('/create', [ServiceCardController::class, 'create'])->name('create')->can('create', ServiceCard::class);
    Route::post('/', [ServiceCardController::class, 'store'])->name('store')->can('create', ServiceCard::class);
    Route::get('/{ServiceCard}', [ServiceCardController::class, 'show'])->name('show')->can('view', 'ServiceCard');
    Route::get('/get/{ServiceCard}', [ServiceCardController::class, 'showDetail'])->name('detail')->can('detail', 'ServiceCard');
    Route::get('/remarks/{ServiceCard}', [ServiceCardController::class, 'showRemarks'])->name('remarks')->can('detail', 'ServiceCard');
    Route::get('/card/{ServiceCard}', [ServiceCardController::class, 'viewCard'])->name('viewCard')->can('viewCard', ServiceCard::class);
    Route::delete('/{ServiceCard}', [ServiceCardController::class, 'destroy'])->name('destroy')->can('delete', 'ServiceCard');

    Route::patch('/pending/{ServiceCard}', [ServiceCardActionController::class, 'pending'])->name('pending')->can('pending', ServiceCard::class);
    Route::patch('/verify/{ServiceCard}', [ServiceCardActionController::class, 'verify'])->name('verify')->can('verify', ServiceCard::class);
    Route::patch('/reject/{ServiceCard}', [ServiceCardActionController::class, 'reject'])->name('reject')->can('reject', ServiceCard::class);
    Route::patch('/restore/{ServiceCard}', [ServiceCardActionController::class, 'restore'])->name('restore')->can('restore', 'ServiceCard');
    Route::patch('/renew/{ServiceCard}', [ServiceCardActionController::class, 'renew'])->name('renew')->can('renew', ServiceCard::class);
    Route::patch('/mark-lost/{ServiceCard}', [ServiceCardActionController::class, 'markLost'])->name('markLost')->can('markLost', ServiceCard::class);
    Route::patch('/duplicate/{ServiceCard}', [ServiceCardActionController::class, 'duplicate'])->name('duplicate')->can('duplicate', ServiceCard::class);
    Route::patch('/mark-printed/{ServiceCard}', [ServiceCardActionController::class, 'markPrinted'])->name('markPrinted')->can('markPrinted', ServiceCard::class);

    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/search', [ServiceCardUserController::class, 'search'])->name('search')->can('searchUsers', ServiceCard::class);
        Route::post('/store', [ServiceCardUserController::class, 'storeUser'])->name('store')->can('createUser', ServiceCard::class);
        Route::post('/update/{user}', [ServiceCardUserController::class, 'updateProfile'])->name('update')->can('updateUser', ServiceCard::class);
        Route::patch('/update/field/{ServiceCard}', [ServiceCardUserController::class, 'updateField'])->name('updateField')->can('updateField', 'ServiceCard');
        Route::post('/upload/file/{ServiceCard}', [ServiceCardUserController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'ServiceCard');
    });
});