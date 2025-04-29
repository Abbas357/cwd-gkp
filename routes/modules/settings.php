<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\Settings\DistrictController;
use App\Http\Controllers\Settings\ActivityLogController;

Route::prefix('settings')->group(function () {
    
    Route::as('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'settings'])->name('index')->can('viewVehicleSettings', App\Models\Setting::class);
        Route::post('/update', [SettingController::class, 'update'])->name('update')->can('updateVehicleSettings', App\Models\Setting::class);
        Route::post('/init', [SettingController::class, 'init'])->name('init')->can('initVehicleSettings', App\Models\Setting::class);
    });

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('districts')->as('districts.')->middleware('can:manageDistricts,' . App\Models\Setting::class)->group(function () {
        Route::get('/', [DistrictController::class, 'index'])->name('index');
        Route::post('/', [DistrictController::class, 'store'])->name('store');
        Route::delete('/{district}', [DistrictController::class, 'destroy'])->name('destroy');
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