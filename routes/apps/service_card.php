<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceCard\HomeController;
use App\Http\Controllers\ServiceCard\ServiceCardController;
use App\Http\Controllers\ServiceCard\ServiceCardUserController;
use App\Http\Controllers\ServiceCard\ServiceCardActionController;

Route::prefix('service_cards')->as('service_cards.')->group(function () {

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/', [HomeController::class, 'settings'])->name('index')->can('viewSettings', App\Models\ServiceCard::class);
        Route::post('/update', [HomeController::class, 'update'])->name('update')->can('updateSettings', App\Models\ServiceCard::class);
        Route::post('/init', [HomeController::class, 'init'])->name('init')->can('initSettings', App\Models\ServiceCard::class);
    });
    
    Route::get('/', [ServiceCardController::class, 'index'])->name('index');
    Route::get('/create', [ServiceCardController::class, 'create'])->name('create');
    Route::post('/', [ServiceCardController::class, 'store'])->name('store');
    Route::get('/search/users', [ServiceCardUserController::class, 'search'])->name('search.users');
    Route::post('/store/user', [ServiceCardUserController::class, 'storeUser'])->name('store.user');
    Route::post('/update/{user}', [ServiceCardUserController::class, 'updateProfile'])->name('update.user');
    Route::get('/{ServiceCard}', [ServiceCardController::class, 'show'])->name('show');
    Route::get('/get/{ServiceCard}', [ServiceCardController::class, 'showDetail'])->name('detail');
    Route::get('/card/{ServiceCard}', [ServiceCardController::class, 'showCard'])->name('showCard');
    Route::patch('/verify/{ServiceCard}', [ServiceCardActionController::class, 'verify'])->name('verify');
    Route::patch('/reject/{ServiceCard}', [ServiceCardActionController::class, 'reject'])->name('reject');
    Route::patch('/restore/{ServiceCard}', [ServiceCardActionController::class, 'restore'])->name('restore');
    Route::patch('/renew/{ServiceCard}', [ServiceCardActionController::class, 'renew'])->name('renew');
    Route::patch('/update/field/{ServiceCard}', [ServiceCardUserController::class, 'updateField'])->name('updateField');
    Route::post('/upload/file/{ServiceCard}', [ServiceCardUserController::class, 'uploadFile'])->name('uploadFile');
    
    // New routes for card status management
    Route::patch('/update-status/{ServiceCard}', [ServiceCardActionController::class, 'updateStatus'])->name('updateStatus');
    Route::patch('/revoke/{ServiceCard}', [ServiceCardActionController::class, 'revoke'])->name('revoke');
    Route::patch('/mark-lost/{ServiceCard}', [ServiceCardActionController::class, 'markLost'])->name('markLost');
    Route::patch('/reprint/{ServiceCard}', [ServiceCardActionController::class, 'reprint'])->name('reprint');
});

// Route::prefix('service_cards')->as('service_cards.')->group(function () {
//     Route::get('/', [ServiceCardController::class, 'index'])->name('index')->can('viewAny', App\Models\ServiceCard::class);
//     Route::get('/create', [ServiceCardController::class, 'create'])->name('create')->can('create', App\Models\ServiceCard::class);
//     Route::post('/', [ServiceCardController::class, 'store'])->name('store')->can('create', App\Models\ServiceCard::class);
//     Route::get('/search/users', [ServiceCardUserController::class, 'search'])->name('search.users')->can('search', App\Models\ServiceCard::class);
//     Route::post('/store/user', [ServiceCardController::class, 'storeUser'])->name('store.user')->can('create', App\Models\ServiceCard::class);
//     Route::post('/update/{user}', [ServiceCardController::class, 'updateProfile'])->name('update.user')->can('update', App\Models\ServiceCard::class);
//     Route::get('/{ServiceCard}', [ServiceCardController::class, 'show'])->name('show')->can('view', 'ServiceCard');
//     Route::get('/get/{ServiceCard}', [ServiceCardController::class, 'showDetail'])->name('detail')->can('view', 'ServiceCard');
//     Route::get('/card/{ServiceCard}', [ServiceCardController::class, 'showCard'])->name('showCard')->can('viewCard', 'ServiceCard');
//     Route::patch('/verify/{ServiceCard}', [ServiceCardController::class, 'verify'])->name('verify')->can('verify', 'ServiceCard');
//     Route::patch('/reject/{ServiceCard}', [ServiceCardController::class, 'reject'])->name('reject')->can('reject', 'ServiceCard');
//     Route::patch('/restore/{ServiceCard}', [ServiceCardController::class, 'restore'])->name('restore')->can('restore', 'ServiceCard');
//     Route::patch('/renew/{ServiceCard}', [ServiceCardController::class, 'renew'])->name('renew')->can('renew', 'ServiceCard');
//     Route::patch('/update/field/{ServiceCard}', [ServiceCardController::class, 'updateField'])->name('updateField')->can('updateField', 'ServiceCard');
//     Route::post('/upload/file/{ServiceCard}', [ServiceCardController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'ServiceCard');
    
//     // New routes for card status management
//     Route::patch('/update-status/{ServiceCard}', [ServiceCardActionController::class, 'updateStatus'])->name('updateStatus')->can('updateStatus', 'ServiceCard');
//     Route::patch('/revoke/{ServiceCard}', [ServiceCardActionController::class, 'revoke'])->name('revoke')->can('revoke', 'ServiceCard');
//     Route::patch('/mark-lost/{ServiceCard}', [ServiceCardActionController::class, 'markLost'])->name('markLost')->can('markLost', 'ServiceCard');
//     Route::patch('/reprint/{ServiceCard}', [ServiceCardActionController::class, 'reprint'])->name('reprint')->can('reprint', 'ServiceCard');
// });