<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Categories\RoleController;
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
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');

    Route::delete('{user}/role/{role}', [UserController::class, 'revokeRole'])->name('users.role.revoke');
    Route::delete('{user}/roles/clear', [UserController::class, 'clearRoles'])->name('users.roles.clear');
    
    Route::post('/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
});

Route::middleware('auth')->prefix('registrations')->group(function () {
    Route::get('/', [ContractorRegistrationController::class, 'index'])->name('registrations.index');
    Route::patch('/defer/{ContractorRegistration}', [ContractorRegistrationController::class, 'defer'])->name('registrations.defer');
    Route::patch('/approve/{ContractorRegistration}', [ContractorRegistrationController::class, 'approve'])->name('registrations.approve');
    Route::get('/{ContractorRegistration}', [ContractorRegistrationController::class, 'show'])->name('registrations.show');
    Route::get('/{ContractorRegistration}/edit', [ContractorRegistrationController::class, 'edit'])->name('registrations.edit');
    Route::patch('/{ContractorRegistration}', [ContractorRegistrationController::class, 'update'])->name('registrations.update');
});

Route::middleware('auth')->prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::post('/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
});

Route::middleware('auth')->prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::post('/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
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

require __DIR__ . '/auth.php';
