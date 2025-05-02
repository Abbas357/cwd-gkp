<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LaravelLogController;
use App\Http\Controllers\ActivityLogController;

Route::prefix('settings')->as('settings.')->group(function () {
    
    Route::prefix('core')->name('core.')->middleware('can:manageCoreSettings,' . App\Models\Setting::class)->group(function () {
        Route::get('/', [SettingController::class, 'settings'])->name('index');
        Route::post('/update', [SettingController::class, 'update'])->name('update');
        Route::post('/init', [SettingController::class, 'init'])->name('init');
    });

    Route::prefix('logs')->name('logs.')->middleware('can:manageLaravelLogs,' . App\Models\Setting::class)->group(function () {
        Route::get('/', [LaravelLogController::class, 'index'])->name('index');
        Route::get('/files', [LaravelLogController::class, 'getLogFiles'])->name('files');
        Route::get('/download/{filename}', [LaravelLogController::class, 'downloadLog'])->name('download');
        Route::delete('/delete/{filename}', [LaravelLogController::class, 'deleteLog'])->name('delete');
        Route::post('/clear', [LaravelLogController::class, 'clearLogs'])->name('clear');
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