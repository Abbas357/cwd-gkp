<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController as AdminController;
use App\Http\Controllers\Site\HomeController as SiteController;
    
Route::get('/', [SiteController::class, 'site'])->name('site');

Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {
    Route::get('/apps', [AdminController::class, 'masterAdmin'])->name('apps');

    require __DIR__ . '/modules/admin.php';
    require __DIR__ . '/modules/settings.php';

    Route::prefix('apps')->as('apps.')->middleware(['auth'])->group(function () {
        require __DIR__ . '/modules/contractor.php';
        require __DIR__ . '/modules/service_card.php';
        require __DIR__ . '/modules/standardization.php';
        require __DIR__ . '/modules/vehicle.php';
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/modules/site.php';
