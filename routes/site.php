<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\EStandardizationController;
use App\Http\Controllers\ContractorRegistrationController;

Route::prefix('registrations')->as('registrations.')->group(function () {
    Route::get('/create', [ContractorRegistrationController::class, 'create'])->name('create');
    Route::post('/', [ContractorRegistrationController::class, 'store'])->name('store');
    Route::post('/check-pec', [ContractorRegistrationController::class, 'checkPEC'])->name('checkPEC');
    Route::get('/approved/{id}', [ContractorRegistrationController::class, 'approvedContractors'])->name('approved');
});

Route::prefix('standardizations')->as('standardizations.')->group(function () {
    Route::get('/create', [EStandardizationController::class, 'create'])->name('create');
    Route::post('/', [EStandardizationController::class, 'store'])->name('store');
    Route::get('/approved/{id}', [EStandardizationController::class, 'approvedProducts'])->name('approved');
});

Route::prefix('stories')->as('stories.')->group(function () {
    Route::get('/', [StoryController::class, 'getStories'])->name('get');
    Route::patch('/viewed/{story}', [StoryController::class, 'incrementSeen'])->name('viewed');
});
