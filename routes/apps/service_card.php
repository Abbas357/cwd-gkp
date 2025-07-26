<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceCard\HomeController;
use App\Http\Controllers\ServiceCard\ServiceCardController;
use App\Http\Controllers\ServiceCard\ServiceCardUserController;
use App\Http\Controllers\ServiceCard\ServiceCardActionController;

Route::prefix('service_cards')->as('service_cards.')->group(function () {
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
    
    Route::patch('/mark-lost/{ServiceCard}', [ServiceCardActionController::class, 'markLost'])->name('markLost');
    Route::patch('/reprint/{ServiceCard}', [ServiceCardActionController::class, 'reprint'])->name('reprint');
    Route::patch('/mark-printed/{ServiceCard}', [ServiceCardActionController::class, 'markPrinted'])->name('markPrinted');
});