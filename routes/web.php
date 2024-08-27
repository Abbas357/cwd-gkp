<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ContractorRegistrationController;

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
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
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

Route::middleware('auth')->prefix('collections')->group(function () {
    Route::get('/', [CollectionController::class, 'index'])->name('collections.index');
    Route::post('/', [CollectionController::class, 'store'])->name('collections.store');
    Route::delete('/{collection}', [CollectionController::class, 'destroy'])->name('collections.destroy');
});

Route::middleware('auth')->prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::post('/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
});
Route::get('/collections/filter', [CollectionController::class, 'filterByType'])->name('collections.filter');


Route::middleware('auth')->prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::post('/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
});

require __DIR__ . '/auth.php';
