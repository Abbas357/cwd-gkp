<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController as AdminController;
use App\Http\Controllers\Site\HomeController as SiteController;
    
Route::get('/', [SiteController::class, 'site'])->name('site');

Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {
    Route::get('/apps', [AdminController::class, 'masterAdmin'])->name('apps');

    require __DIR__ . '/admin.php';
    require __DIR__ . '/settings.php';

    Route::prefix('apps')->as('apps.')->group(function () {
        require __DIR__ . '/apps/hr.php';
        require __DIR__ . '/apps/contractor.php';
        require __DIR__ . '/apps/consultant.php';
        require __DIR__ . '/apps/service_card.php';
        require __DIR__ . '/apps/standardization.php';
        require __DIR__ . '/apps/vehicle.php';
        require __DIR__ . '/apps/porms.php';
        require __DIR__ . '/apps/machinery.php';
        require __DIR__ . '/apps/dmis.php';
    });
    
});

require __DIR__ . '/auth.php';
require __DIR__ . '/site.php';