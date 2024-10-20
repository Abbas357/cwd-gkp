<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EStandardizationController;
use App\Http\Controllers\ContractorRegistrationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\Categories\OfficeController;
use App\Http\Controllers\Categories\RoleController;
use App\Http\Controllers\Categories\DistrictController;
use App\Http\Controllers\Categories\PermissionController;
use App\Http\Controllers\Categories\DesignationController;
use App\Http\Controllers\Categories\ProvincialEntityController;
use App\Http\Controllers\Categories\ContractorCategoryController;

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->as('admin.')->group(function () {

        Route::prefix('profile')->as('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/api', [UserController::class, 'users'])->name('api');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::patch('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('registrations')->as('registrations.')->group(function () {
            Route::get('/', [ContractorRegistrationController::class, 'index'])->name('index');
            Route::patch('/defer/{ContractorRegistration}', [ContractorRegistrationController::class, 'defer'])->name('defer');
            Route::patch('/approve/{ContractorRegistration}', [ContractorRegistrationController::class, 'approve'])->name('approve');
            Route::get('/{ContractorRegistration}', [ContractorRegistrationController::class, 'show'])->name('show');
            Route::get('/get/{ContractorRegistration}', [ContractorRegistrationController::class, 'showDetail'])->name('showDetail');
            Route::get('/card/{ContractorRegistration}', [ContractorRegistrationController::class, 'showCard'])->name('showCard');
            Route::patch('/update-field', [ContractorRegistrationController::class, 'updateField'])->name('updateField');
            Route::patch('/upload-file', [ContractorRegistrationController::class, 'uploadFile'])->name('uploadFile');
        });

        Route::prefix('standardizations')->as('standardizations.')->group(function () {
            Route::get('/', [EStandardizationController::class, 'index'])->name('index');
            Route::patch('/approve/{EStandardization}', [EStandardizationController::class, 'approve'])->name('approve');
            Route::patch('/reject/{EStandardization}', [EStandardizationController::class, 'reject'])->name('reject');
            Route::get('/{EStandardization}', [EStandardizationController::class, 'show'])->name('show');
            Route::get('/get/{EStandardization}', [EStandardizationController::class, 'showDetail'])->name('showDetail');
            Route::get('/card/{EStandardization}', [EStandardizationController::class, 'showCard'])->name('showCard');
            Route::patch('/update-field', [EStandardizationController::class, 'updateField'])->name('updateField');
            Route::patch('/upload-file', [EStandardizationController::class, 'uploadFile'])->name('uploadFile');
        });

        Route::prefix('stories')->as('stories.')->group(function () {
            Route::get('/', [StoryController::class, 'index'])->name('index');
            Route::get('/create', [StoryController::class, 'create'])->name('create');
            Route::post('/', [StoryController::class, 'store'])->name('store');
            Route::patch('/publish/{story}', [StoryController::class, 'publishStory'])->name('publish');
            Route::get('/{story}', [StoryController::class, 'show'])->name('show');
            Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');

            Route::get('/{role}/permissions', [RoleController::class, 'getPermissions'])->name('getPermissions');
            Route::patch('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('updatePermissions');
        });

        Route::prefix('permissions')->as('permissions.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('districts')->as('districts.')->group(function () {
            Route::get('/', [DistrictController::class, 'index'])->name('index');
            Route::post('/', [DistrictController::class, 'store'])->name('store');
            Route::delete('/{district}', [DistrictController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('contractor_categories')->as('contractor_categories.')->group(function () {
            Route::get('/', [ContractorCategoryController::class, 'index'])->name('index');
            Route::post('/', [ContractorCategoryController::class, 'store'])->name('store');
            Route::delete('/{contractor_category}', [ContractorCategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('designations')->as('designations.')->group(function () {
            Route::get('/', [DesignationController::class, 'index'])->name('index');
            Route::post('/', [DesignationController::class, 'store'])->name('store');
            Route::delete('/{designation}', [DesignationController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('offices')->as('offices.')->group(function () {
            Route::get('/', [OfficeController::class, 'index'])->name('index');
            Route::post('/', [OfficeController::class, 'store'])->name('store');
            Route::delete('/{office}', [OfficeController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('provincial_entities')->as('provincial_entities.')->group(function () {
            Route::get('/', [ProvincialEntityController::class, 'index'])->name('index');
            Route::post('/', [ProvincialEntityController::class, 'store'])->name('store');
            Route::delete('/{provincial_entity}', [ProvincialEntityController::class, 'destroy'])->name('destroy');
        });

        Route::get('/logs', ActivityLogController::class)->name('logs');
    });
});