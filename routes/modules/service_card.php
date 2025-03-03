<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceCard\CardController;
use App\Http\Controllers\ServiceCard\ServiceCardController;

Route::prefix('service_cards')->as('service_cards.')->middleware(['can:manage service cards'])->group(function () {
    Route::get('/', [ServiceCardController::class, 'index'])->name('index')->can('viewAny', App\Models\ServiceCard::class);
    Route::get('/{service_card}', [ServiceCardController::class, 'show'])->name('show')->can('view', App\Models\ServiceCard::class);
    Route::get('/get/{service_card}', [ServiceCardController::class, 'showDetail'])->name('detail')->can('view', 'service_card');
    Route::get('/card/{service_card}', [ServiceCardController::class, 'showCard'])->name('showCard')->can('view', 'service_card');
    Route::patch('/verify/{service_card}', [ServiceCardController::class, 'verify'])->name('verify')->can('verify', 'service_card');
    Route::patch('/reject/{service_card}', [ServiceCardController::class, 'reject'])->name('reject')->can('reject', 'service_card');
    Route::patch('/restore/{service_card}', [ServiceCardController::class, 'restore'])->name('restore')->can('restore', 'service_card');
    Route::patch('/renew/{service_card}', [ServiceCardController::class, 'renew'])->name('renew')->can('renew', 'service_card');
    Route::patch('/update/field/{service_card}', [ServiceCardController::class, 'updateField'])->name('updateField')->can('update', 'service_card');
    Route::patch('/upload/file/{service_card}', [ServiceCardController::class, 'uploadFile'])->name('uploadFile')->can('update', 'service_card');
});

Route::prefix('cards')->as('cards.')->group(function () {
    Route::get('/', [CardController::class, 'index'])->name('index')->can('view', App\Models\Card::class);
});
