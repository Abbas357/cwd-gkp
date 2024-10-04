<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractorRegistrationController;
use App\Http\Controllers\EStandardizationController;

Route::get('registrations/create', [ContractorRegistrationController::class, 'create'])->name('registrations.create');
Route::post('registrations', [ContractorRegistrationController::class, 'store'])->name('registrations.store');
Route::post('registrations/check-pec-number', [ContractorRegistrationController::class, 'checkPecNumber'])->name('check.pec.number');
Route::get('registrations/approved/{id}', [ContractorRegistrationController::class, 'approvedContractors'])->name('registrations.approved');

Route::get('standardizations/create', [EStandardizationController::class, 'create'])->name('standardizations.create');
Route::post('standardizations', [EStandardizationController::class, 'store'])->name('standardizations.store');
Route::get('standardizations/approved/{id}', [EStandardizationController::class, 'approvedProducts'])->name('standardizations.approved');
