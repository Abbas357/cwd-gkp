<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contractor\ContractorController;
use App\Http\Controllers\Contractor\ContractorMachineryController;
use App\Http\Controllers\Contractor\ContractorRegistrationController;
use App\Http\Controllers\Contractor\ContractorHumanResourceController;
use App\Http\Controllers\Contractor\ContractorWorkExperienceController;

Route::prefix('contractors')->as('contractors.')->middleware(['can:manage contractors'])->group(function () {
    Route::get('/', [ContractorController::class, 'index'])->name('index')->can('viewAny', App\Models\Contractor::class);
    Route::get('/{Contractor}/detail', [ContractorController::class, 'detail'])->name('detail')->can('view', 'Contractor');
    Route::patch('/update/field/{Contractor}', [ContractorController::class, 'updateField'])->name('updateField')->can('update', 'Contractor');
    Route::patch('/update/file/{Contractor}', [ContractorController::class, 'uploadFile'])->name('uploadFile')->can('update', 'Contractor');

    Route::prefix('hr')->as('hr.')->group(function () {
        Route::get('/{Contractor}', [ContractorHumanResourceController::class, 'detail'])->name('detail')->can('view', 'Contractor');
        Route::post('/{id}/update', [ContractorHumanResourceController::class, 'update'])->name('update');
        Route::patch('/{id}/upload', [ContractorHumanResourceController::class, 'upload'])->name('upload');
        Route::delete('{id}', [ContractorHumanResourceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('machinery')->as('machinery.')->group(function () {
        Route::get('/{Contractor}', [ContractorMachineryController::class, 'detail'])->name('detail')->can('view', 'Contractor');
        Route::post('/{id}/update', [ContractorMachineryController::class, 'update'])->name('update');
        Route::patch('/{id}/upload', [ContractorMachineryController::class, 'upload'])->name('upload');
        Route::delete('{id}', [ContractorMachineryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('experience')->as('experience.')->group(function () {
        Route::get('/{Contractor}', [ContractorWorkExperienceController::class, 'detail'])->name('detail')->can('view', 'Contractor');
        Route::post('/{id}/update', [ContractorWorkExperienceController::class, 'update'])->name('update');
        Route::patch('/{id}/upload', [ContractorWorkExperienceController::class, 'upload'])->name('upload');
        Route::delete('{id}', [ContractorWorkExperienceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('registration')->as('registration.')->group(function () {
        Route::get('/', [ContractorRegistrationController::class, 'index'])->name('index')->can('viewAny', App\Models\ContractorRegistration::class);
        Route::patch('/defer/{ContractorRegistration}', [ContractorRegistrationController::class, 'defer'])->name('defer')->can('defer', 'Contractor');
        Route::patch('/approve/{ContractorRegistration}', [ContractorRegistrationController::class, 'approve'])->name('approve')->can('approve', 'Contractor');
        Route::get('/{ContractorRegistration}', [ContractorRegistrationController::class, 'show'])->name('show')->can('view', 'Contractor');
        Route::get('/get/{ContractorRegistration}', [ContractorRegistrationController::class, 'showDetail'])->name('showDetail')->can('view', 'Contractor');
        Route::get('/card/{ContractorRegistration}', [ContractorRegistrationController::class, 'showCard'])->name('showCard')->can('card', 'Contractor');
        Route::patch('/renew/{ContractorRegistration}', [ContractorRegistrationController::class, 'renew'])->name('renew')->can('renew', 'Contractor');
        Route::patch('/update/field/{ContractorRegistration}', [ContractorRegistrationController::class, 'updateField'])->name('updateField')->can('update', 'Contractor');
        Route::patch('/update/file/{ContractorRegistration}', [ContractorRegistrationController::class, 'uploadFile'])->name('uploadFile')->can('update', 'Contractor');
    });
});
