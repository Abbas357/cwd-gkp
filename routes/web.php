<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;

Route::get('/', [HomePageController::class, 'site'])->name('site');
Route::get('/admin/dashboard', [HomePageController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/site.php';
require __DIR__ . '/admin.php';