<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractorRegistrationController;

Route::get('registrations/create', [ContractorRegistrationController::class, 'create'])->name('registrations.create');
Route::post('registrations', [ContractorRegistrationController::class, 'store'])->name('registrations.store');
Route::post('registrations/check-pec-number', [ContractorRegistrationController::class, 'checkPecNumber'])->name('check.pec.number');

