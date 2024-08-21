<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContractorRegistrationController;
use App\Http\Controllers\CollectionController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/noauth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/{user}', [UserController::class, 'update'])->name('users.update');
});

Route::middleware('auth')->prefix('registrations')->group(function () {
    Route::get('/', [ContractorRegistrationController::class, 'index'])->name('registrations.index');

    // Route::get('/data', [ContractorRegistrationController::class, 'data'])->name('registrations.data');
    
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



require __DIR__.'/auth.php';
