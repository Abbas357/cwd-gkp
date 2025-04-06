<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\Settings\DistrictController;
use App\Http\Controllers\Settings\ActivityLogController;

Route::prefix('settings')->middleware(['can:manage settings'])->group(function () {
    
    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('core')->as('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index')->can('view', App\Models\Setting::class);
        Route::patch('/', [SettingController::class, 'update'])->name('update')->can('update', App\Models\Setting::class);
    });

    Route::prefix('categories')->as('categories.')->group(function () {
        Route::get('/', [SettingController::class, 'categories'])->name('index')->can('viewAny', App\Models\Setting::class);
        Route::get('/create', [SettingController::class, 'createCategory'])->name('create')->can('create', App\Models\Setting::class);
        Route::post('/', [SettingController::class, 'storeCategory'])->name('store')->can('create', App\Models\Setting::class);
        Route::get('/{key}/{module?}', [SettingController::class, 'showCategory'])->name('show')->can('view', App\Models\Setting::class);
        Route::get('/{key}/{module?}/edit', [SettingController::class, 'editCategory'])->name('edit')->can('update', App\Models\Setting::class);
        Route::patch('/{key}/{module?}', [SettingController::class, 'updateCategory'])->name('update')->can('update', App\Models\Setting::class);
        Route::delete('/{key}/{module?}', [SettingController::class, 'deleteCategory'])->name('destroy')->can('delete', App\Models\Setting::class);
        
        // AJAX Category Item Management
        Route::get('/{key}/{module?}/items', [SettingController::class, 'getCategoryItems'])->name('items')->can('view', App\Models\Setting::class);
        Route::post('/{key}/{module?}/items', [SettingController::class, 'addCategoryItem'])->name('items.add')->can('update', App\Models\Setting::class);
        Route::delete('/{key}/{module?}/items', [SettingController::class, 'removeCategoryItem'])->name('items.remove')->can('update', App\Models\Setting::class);
    });

    Route::prefix('districts')->as('districts.')->group(function () {
        Route::get('/', [DistrictController::class, 'index'])->name('index')->can('viewAny', App\Models\District::class);
        Route::post('/', [DistrictController::class, 'store'])->name('store')->can('create', App\Models\District::class);
        Route::delete('/{district}', [DistrictController::class, 'destroy'])->name('destroy')->can('delete', App\Models\District::class);
    });

    Route::prefix('search')->as('search.')->group(function () {
        Route::get('/links', [HomeController::class, 'searchLinks'])->name('links');
        Route::post('/clear', [HomeController::class, 'clearRecentSearches'])->name('clear');
    });

    Route::prefix('activity')->as('activity.')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index')->can('view', Spatie\Activitylog\Models\Activity::class);
        Route::get('/notifications', [ActivityLogController::class, 'getNotifications'])->name('notifications');
    });
    
});