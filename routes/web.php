<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController as AdminController;
use App\Http\Controllers\Site\HomeController as SiteController;

Route::get('/dump-autoload', function () {
    if (app()->environment('local')) { // Restrict to local environment
        return Artisan::call('composer:dump-autoload');
    } else {
        return response('Forbidden', 403);
    }
});
Route::get('/artisan', function () {
    // Artisan::call('storage:link');
    // Artisan::call('config:cache');
    // Artisan::call('route:cache');
    // Artisan::call('composer:dump-autoload');
    // Artisan::call('view:cache');
    // Artisan::call('optimize');

    // Artisan::call('view:clear');
    Artisan::call('route:clear');
    // Artisan::call('cache:clear');
    return 'Command executed successfully.';
});
Route::get('/', [SiteController::class, 'site'])->name('site');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/site.php';
require __DIR__ . '/admin.php';