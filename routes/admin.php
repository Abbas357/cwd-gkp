<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EStandardizationController;
use App\Http\Controllers\ContractorRegistrationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\GalleryController;

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
            Route::patch('/activate/{user}', [UserController::class, 'activateUser'])->name('activate');
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
            Route::get('/get/{EStandardization}', [EStandardizationController::class, 'showDetail'])->name('detail');
            Route::get('/card/{EStandardization}', [EStandardizationController::class, 'showCard'])->name('card');
            Route::patch('/update/field', [EStandardizationController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [EStandardizationController::class, 'uploadFile'])->name('uploadFile');
        });

        Route::prefix('downloads')->as('downloads.')->group(function () {
            Route::get('/', [DownloadController::class, 'index'])->name('index');
            Route::get('/create', [DownloadController::class, 'create'])->name('create');
            Route::post('/', [DownloadController::class, 'store'])->name('store');
            Route::get('/{download}', [DownloadController::class, 'show'])->name('show');
            Route::get('/get/{download}', [DownloadController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{download}', [DownloadController::class, 'publishDownload'])->name('publish');
            Route::patch('/archive/{download}', [DownloadController::class, 'archiveDownload'])->name('archive');
            Route::patch('/update/field', [DownloadController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [DownloadController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{download}', [DownloadController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('gallery')->as('gallery.')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::get('/create', [GalleryController::class, 'create'])->name('create');
            Route::post('/', [GalleryController::class, 'store'])->name('store');
            Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show');
            Route::get('/get/{gallery}', [GalleryController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{gallery}', [GalleryController::class, 'publishGallery'])->name('publish');
            Route::patch('/archive/{gallery}', [GalleryController::class, 'archiveGallery'])->name('archive');
            Route::patch('/update/field', [GalleryController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [GalleryController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
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

        Route::prefix('categories')->as('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('districts')->as('districts.')->group(function () {
            Route::get('/', [DistrictController::class, 'index'])->name('index');
            Route::post('/', [DistrictController::class, 'store'])->name('store');
            Route::delete('/{district}', [DistrictController::class, 'destroy'])->name('destroy');
        });

        Route::get('/logs', ActivityLogController::class)->name('logs');
    });
});