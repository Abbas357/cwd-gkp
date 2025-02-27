<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\Settings\CategoryController;
use App\Http\Controllers\Settings\DistrictController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\ActivityLogController;

Route::prefix('settings')->middleware(['can:manage settings'])->group(function () {
    
    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('roles')->as('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index')->can('viewAny', Spatie\Permission\Models\Role::class);
        Route::post('/', [RoleController::class, 'store'])->name('store')->can('create', Spatie\Permission\Models\Role::class);
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->can('delete', 'role');
        Route::get('/{role}/permissions', [RoleController::class, 'getPermissions'])->name('getPermissions')->can('update', Spatie\Permission\Models\Role::class);
        Route::patch('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('updatePermissions')->can('update', Spatie\Permission\Models\Role::class);
    });

    Route::prefix('permissions')->as('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index')->can('viewAny', Spatie\Permission\Models\Permission::class);
        Route::post('/', [PermissionController::class, 'store'])->name('store')->can('create', Spatie\Permission\Models\Permission::class);
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy')->can('delete', 'permission');
    });

    Route::prefix('core')->as('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index')->can('view', App\Models\Setting::class);
        Route::patch('/', [SettingController::class, 'update'])->name('update')->can('update', App\Models\Setting::class);
    });

    Route::prefix('categories')->as('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index')->can('viewAny', App\Models\Category::class);
        Route::post('/', [CategoryController::class, 'store'])->name('store')->can('create', App\Models\Category::class);
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy')->can('delete', 'category');
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

    Route::get('/logs', ActivityLogController::class)->name('logs')->can('view', Spatie\Activitylog\Models\Activity::class);
});