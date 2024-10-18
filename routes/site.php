<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\EStandardizationController;
use App\Http\Controllers\Admin\ContractorRegistrationController;

Route::get('/', [SiteController::class, 'index'])->name('site');

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

Route::get('/stories', [StoryController::class, 'getStories'])->name('get.stories');
