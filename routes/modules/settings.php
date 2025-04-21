<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\Settings\DistrictController;
use App\Http\Controllers\Settings\ActivityLogController;

Route::prefix('settings')->group(function () {
    
    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('core')->as('settings.')->middleware('can:updateCore,' . App\Models\Setting::class)->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::patch('/', [SettingController::class, 'update'])->name('update');
    });

    Route::prefix('categories')->as('categories.')->middleware('can:manageMainCategory,' . App\Models\Setting::class)->group(function () {
        Route::get('/', [SettingController::class, 'categories'])->name('index');
        Route::get('/create', [SettingController::class, 'createCategory'])->name('create');
        Route::post('/', [SettingController::class, 'storeCategory'])->name('store');
        Route::get('/{key}/{module?}', [SettingController::class, 'showCategory'])->name('show');
        Route::get('/{key}/{module?}/edit', [SettingController::class, 'editCategory'])->name('edit');
        Route::patch('/{key}/{module?}', [SettingController::class, 'updateCategory'])->name('update');
        Route::delete('/{key}/{module?}', [SettingController::class, 'deleteCategory'])->name('destroy');
        
        Route::get('/{key}/{module?}/items', [SettingController::class, 'getCategoryItems'])->name('items');
        Route::post('/{key}/{module?}/items', [SettingController::class, 'addCategoryItem'])->name('items.add');
        Route::delete('/{key}/{module?}/items', [SettingController::class, 'removeCategoryItem'])->name('items.remove');
    });

    Route::prefix('districts')->as('districts.')->middleware('can:manageDistricts,' . App\Models\Setting::class)->group(function () {
        Route::get('/', [DistrictController::class, 'index'])->name('index');
        Route::post('/', [DistrictController::class, 'store'])->name('store');
        Route::delete('/{district}', [DistrictController::class, 'destroy']);
    });

    Route::prefix('search')->as('search.')->group(function () {
        Route::get('/links', [HomeController::class, 'searchLinks'])->name('links');
        Route::post('/clear', [HomeController::class, 'clearRecentSearches'])->name('clear');
    });

    Route::prefix('activity')->as('activity.')->middleware('can:viewActivity,' . App\Models\Setting::class)->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/notifications', [ActivityLogController::class, 'getNotifications'])->name('notifications');
    });
    
});