<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController as AdminController;
use App\Http\Controllers\Site\HomeController as SiteController;
    
Route::get('/', [SiteController::class, 'site'])->name('site');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/site.php';
require __DIR__ . '/admin.php';