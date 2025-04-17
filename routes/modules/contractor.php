<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contractor\ContractorController;
use App\Http\Controllers\Contractor\ContractorMachineryController;
use App\Http\Controllers\Contractor\ContractorRegistrationController;
use App\Http\Controllers\Contractor\ContractorHumanResourceController;
use App\Http\Controllers\Contractor\ContractorWorkExperienceController;

Route::prefix('contractors')->as('contractors.')->middleware(['can:manage contractors'])->group(function () {
    Route::get('/', [ContractorController::class, 'index'])->name('index')->can('viewAny', App\Models\Contractor::class);
    Route::get('/{contractor}/detail', [ContractorController::class, 'detail'])->name('detail')->can('detail', 'contractor');
    Route::patch('/update/field/{contractor}', [ContractorController::class, 'updateField'])->name('updateField')->can('updateField', 'contractor');
    Route::patch('/update/file/{contractor}', [ContractorController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'contractor');

    Route::prefix('hr')->as('hr.')->group(function () {
        Route::get('/{contractor}', [ContractorHumanResourceController::class, 'detail'])->name('detail');
        Route::post('/{id}/update', [ContractorHumanResourceController::class, 'update'])->name('update');
        Route::patch('/{id}/upload', [ContractorHumanResourceController::class, 'upload'])->name('upload');
        Route::delete('{id}', [ContractorHumanResourceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('machinery')->as('machinery.')->group(function () {
        Route::get('/{contractor}', [ContractorMachineryController::class, 'detail'])->name('detail');
        Route::post('/{id}/update', [ContractorMachineryController::class, 'update'])->name('update');
        Route::patch('/{id}/upload', [ContractorMachineryController::class, 'upload'])->name('upload');
        Route::delete('{id}', [ContractorMachineryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('experience')->as('experience.')->group(function () {
        Route::get('/{contractor}', [ContractorWorkExperienceController::class, 'detail'])->name('detail');
        Route::post('/{id}/update', [ContractorWorkExperienceController::class, 'update'])->name('update');
        Route::patch('/{id}/upload', [ContractorWorkExperienceController::class, 'upload'])->name('upload');
        Route::delete('{id}', [ContractorWorkExperienceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('registration')->as('registration.')->group(function () {
        Route::get('/', [ContractorRegistrationController::class, 'index'])->name('index')->can('viewAny', App\Models\ContractorRegistration::class);
        Route::patch('/defer/{contractor_registration}', [ContractorRegistrationController::class, 'defer'])->name('defer')->can('defer', 'contractor_registration');
        Route::patch('/approve/{contractor_registration}', [ContractorRegistrationController::class, 'approve'])->name('approve')->can('approve', 'contractor_registration');
        Route::get('/{contractor_registration}', [ContractorRegistrationController::class, 'show'])->name('show')->can('view', 'contractor_registration');
        Route::get('/get/{contractor_registration}', [ContractorRegistrationController::class, 'showDetail'])->name('showDetail')->can('detail', 'contractor_registration');
        Route::get('/card/{contractor_registration}', [ContractorRegistrationController::class, 'showCard'])->name('showCard')->can('viewCard', 'contractor_registration');
        Route::patch('/renew/{contractor_registration}', [ContractorRegistrationController::class, 'renew'])->name('renew')->can('renew', 'contractor_registration');
        Route::patch('/update/field/{contractor_registration}', [ContractorRegistrationController::class, 'updateField'])->name('updateField')->can('updateField', 'contractor_registration');
        Route::patch('/update/file/{contractor_registration}', [ContractorRegistrationController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'contractor_registration');
    });
});
