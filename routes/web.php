<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Categories\RoleController;
use App\Http\Controllers\EStandardizationController;
use App\Http\Controllers\Categories\DistrictController;
use App\Http\Controllers\Categories\PermissionController;
use App\Http\Controllers\Categories\DesignationController;
use App\Http\Controllers\ContractorRegistrationController;
use App\Http\Controllers\Categories\ProvincialEntityController;
use App\Http\Controllers\Categories\ContractorCategoryController; 

require __DIR__ . '/noauth.php';

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/api', [UserController::class, 'users'])->name('users.api');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::patch('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware('auth')->prefix('registrations')->group(function () {
    Route::get('/', [ContractorRegistrationController::class, 'index'])->name('registrations.index');
    Route::patch('/defer/{ContractorRegistration}', [ContractorRegistrationController::class, 'defer'])->name('registrations.defer');
    Route::patch('/approve/{ContractorRegistration}', [ContractorRegistrationController::class, 'approve'])->name('registrations.approve');
    Route::get('/{ContractorRegistration}', [ContractorRegistrationController::class, 'show'])->name('registrations.show');
    Route::get('/get/{ContractorRegistration}', [ContractorRegistrationController::class, 'showDetail'])->name('registrations.showDetail');
    Route::get('/card/{ContractorRegistration}', [ContractorRegistrationController::class, 'showCard'])->name('registrations.showCard');
    Route::patch('/update-field', [ContractorRegistrationController::class, 'updateField'])->name('registrations.updateField');
    Route::patch('/upload-file', [ContractorRegistrationController::class, 'uploadFile'])->name('registrations.uploadFile');
});

Route::middleware('auth')->prefix('standardizations')->group(function () {
    Route::get('/', [EStandardizationController::class, 'index'])->name('standardizations.index');
    Route::patch('/approve/{EStandardization}', [EStandardizationController::class, 'approve'])->name('standardizations.approve');
    Route::patch('/reject/{EStandardization}', [EStandardizationController::class, 'reject'])->name('standardizations.reject');
    Route::get('/{EStandardization}', [EStandardizationController::class, 'show'])->name('standardizations.show');
    Route::get('/get/{EStandardization}', [EStandardizationController::class, 'showDetail'])->name('standardizations.showDetail');
    Route::get('/card/{EStandardization}', [EStandardizationController::class, 'showCard'])->name('standardizations.showCard');
    Route::patch('/update-field', [EStandardizationController::class, 'updateField'])->name('standardizations.updateField');
    Route::patch('/upload-file', [EStandardizationController::class, 'uploadFile'])->name('standardizations.uploadFile');
});

Route::middleware('auth')->prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/{role}/permissions', [RoleController::class, 'getPermissions'])->name('roles.getPermissions');
    Route::patch('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');
});

Route::middleware('auth')->prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});

Route::middleware('auth')->prefix('districts')->group(function () {
    Route::get('/', [DistrictController::class, 'index'])->name('districts.index');
    Route::post('/', [DistrictController::class, 'store'])->name('districts.store');
    Route::delete('/{district}', [DistrictController::class, 'destroy'])->name('districts.destroy');
});

Route::middleware('auth')->prefix('contractor_categories')->group(function () {
    Route::get('/', [ContractorCategoryController::class, 'index'])->name('contractor_categories.index');
    Route::post('/', [ContractorCategoryController::class, 'store'])->name('contractor_categories.store');
    Route::delete('/{contractor_category}', [ContractorCategoryController::class, 'destroy'])->name('contractor_categories.destroy');
});

Route::middleware('auth')->prefix('designations')->group(function () {
    Route::get('/', [DesignationController::class, 'index'])->name('designations.index');
    Route::post('/', [DesignationController::class, 'store'])->name('designations.store');
    Route::delete('/{designation}', [DesignationController::class, 'destroy'])->name('designations.destroy');
});

Route::middleware('auth')->prefix('offices')->group(function () {
    Route::get('/', [OfficeController::class, 'index'])->name('offices.index');
    Route::post('/', [OfficeController::class, 'store'])->name('offices.store');
    Route::delete('/{office}', [OfficeController::class, 'destroy'])->name('offices.destroy');
});

Route::middleware('auth')->prefix('provincial_entities')->group(function () {
    Route::get('/', [ProvincialEntityController::class, 'index'])->name('provincial_entities.index');
    Route::post('/', [ProvincialEntityController::class, 'store'])->name('provincial_entities.store');
    Route::delete('/{provincial_entity}', [ProvincialEntityController::class, 'destroy'])->name('provincial_entities.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/logs', ActivityLogController::class)->name('logs');
});

require __DIR__ . '/auth.php';
