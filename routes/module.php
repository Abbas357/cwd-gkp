<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Module\CardController;
use App\Http\Controllers\Module\ProductController;
use App\Http\Controllers\Module\VehicleController;
use App\Http\Controllers\Module\ContractorController;
use App\Http\Controllers\Module\ServiceCardController;
use App\Http\Controllers\Module\StandardizationController;
use App\Http\Controllers\Module\VehicleAllotmentController;
use App\Http\Controllers\Module\ContractorMachineryController;
use App\Http\Controllers\Module\ContractorRegistrationController;
use App\Http\Controllers\Module\ContractorHumanResourceController;
use App\Http\Controllers\Module\ContractorWorkExperienceController;

Route::middleware('auth')->group(function () { 
    Route::prefix('module')->as('module.')->group(function () {

        Route::prefix('service_cards')->as('service_cards.')->group(function () {            
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
        
        Route::prefix('contractors')->as('contractors.')->group(function () {
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
        
        Route::prefix('standardizations')->as('standardizations.')->group(function () {
            Route::get('/', [StandardizationController::class, 'index'])->name('index')->can('viewAny', App\Models\Standardization::class);
            Route::patch('/approve/{standardization}', [StandardizationController::class, 'approve'])->name('approve')->can('approve', 'Standardization');
            Route::patch('/reject/{standardization}', [StandardizationController::class, 'reject'])->name('reject')->can('reject', 'Standardization');
            Route::get('/{standardization}', [StandardizationController::class, 'show'])->name('show')->can('view', 'Standardization');
            Route::get('/get/{standardization}', [StandardizationController::class, 'showDetail'])->name('detail')->can('view', 'Standardization');
            Route::get('/card/{standardization}', [StandardizationController::class, 'showCard'])->name('card')->can('card', 'Standardization');
            Route::patch('/renew/{standardization}', [StandardizationController::class, 'renew'])->name('renew')->can('renew', 'Standardization');
            Route::patch('/update/field/{standardization}', [StandardizationController::class, 'updateField'])->name('updateField')->can('update', 'Standardization');
            Route::patch('/upload/file/{standardization}', [StandardizationController::class, 'uploadFile'])->name('uploadFile')->can('update', 'Standardization');
            
            Route::prefix('product')->as('product.')->group(function () {
                Route::get('/{Standardization}', [ProductController::class, 'detail'])->name('detail')->can('view', 'Product');
                Route::post('/{id}/update', [ProductController::class, 'update'])->name('update');
                Route::patch('/{id}/upload', [ProductController::class, 'upload'])->name('upload');
                Route::delete('{id}', [ProductController::class, 'destroy'])->name('destroy');
            });
        });
        
        Route::prefix('cards')->as('cards.')->group(function () {
            Route::get('/', [CardController::class, 'index'])->name('index')->can('view', App\Models\Card::class);
        });
            
        Route::prefix('vehicles')->as('vehicles.')->group(function () {
            Route::get('/', [VehicleController::class, 'index'])->name('index')->can('viewAny', App\Models\Vehicle::class);
            Route::get('/create', [VehicleController::class, 'create'])->name('create')->can('create', App\Models\Vehicle::class);
            Route::get('/dashboard', [VehicleController::class, 'dashboard'])->name('dashboard')->can('view', App\Models\Vehicle::class);
            Route::get('/reports', [VehicleController::class, 'reports'])->name('reports')->can('view', 'vehicle');
            Route::get('/search', [VehicleController::class, 'search'])->name('search')->can('view', 'vehicle');
            Route::post('/', [VehicleController::class, 'store'])->name('store')->can('create', App\Models\Vehicle::class);
            Route::get('/{vehicle}', [VehicleController::class, 'show'])->name('show')->can('view', App\Models\Vehicle::class);
            Route::get('/get/{vehicle}', [VehicleController::class, 'showDetail'])->name('detail')->can('view', 'vehicle');
            Route::get('/history/{vehicle}', [VehicleController::class, 'vehicleHistory'])->name('history')->can('view', 'vehicle');
            Route::patch('/update/field/{vehicle}', [VehicleController::class, 'updateField'])->name('updateField')->can('update', 'vehicle');
            Route::delete('/{vehicle}', [VehicleController::class, 'destroy'])->name('destroy')->can('delete', 'vehicle');
            
            Route::prefix('allotment')->as('allotment.')->group(function () {
                Route::get('/{vehicle}', [VehicleAllotmentController::class, 'create'])->name('create')->can('view', 'allotment');
                Route::post('', [VehicleAllotmentController::class, 'store'])->name('store')->can('view', 'allotment');
                Route::delete('/{allotment}', [VehicleAllotmentController::class, 'delete'])->name('delete')->can('delete', 'allotment');
            });

        });

    });
});