<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Consultant\ConsultantController;
use App\Http\Controllers\Consultant\ConsultantProjectController;
use App\Http\Controllers\Consultant\ConsultantHumanResourceController;

Route::prefix('consultants')->as('consultants.')->group(function () {
    Route::get('/', [ConsultantController::class, 'index'])->name('index')->can('viewAny', App\Models\Consultant::class);
    Route::get('/{consultant}/detail', [ConsultantController::class, 'detail'])->name('detail')->can('view', 'consultant');
    Route::patch('/update/field/{consultant}', [ConsultantController::class, 'updateField'])->name('updateField')->can('updateField', 'consultant');
    Route::patch('/update/file/{consultant}', [ConsultantController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'consultant');

    Route::prefix('hr')->as('hr.')->group(function () {
        Route::get('/{consultant}', [ConsultantHumanResourceController::class, 'detail'])->name('detail')->can('viewAny', App\Models\ConsultantHumanResource::class);
        Route::post('/{id}/update', [ConsultantHumanResourceController::class, 'update'])->name('update')->can('update', App\Models\ConsultantHumanResource::class);
        Route::patch('/{id}/upload', [ConsultantHumanResourceController::class, 'upload'])->name('upload')->can('upload', App\Models\ConsultantHumanResource::class);
        Route::delete('{id}', [ConsultantHumanResourceController::class, 'destroy'])->name('destroy')->can('delete', App\Models\ConsultantHumanResource::class);
    });

    Route::prefix('projects')->as('projects.')->group(function () {
        Route::get('/{consultant}', [ConsultantProjectController::class, 'detail'])->name('detail')->can('viewAny', App\Models\ConsultantProject::class);
        Route::get('consultant-projects/{id}/hr', [ConsultantProjectController::class, 'getAvailableHr'])->name('get-available-hr')->can('viewAny', App\Models\ConsultantProject::class);
        Route::post('consultant-projects/{id}/hr', [ConsultantProjectController::class, 'updateHrAssignments'])->name('update-hr-assignments')->can('viewAny', App\Models\ConsultantProject::class);
        Route::post('/{id}/update', [ConsultantProjectController::class, 'update'])->name('update')->can('update', App\Models\ConsultantProject::class);
        Route::patch('/{id}/upload', [ConsultantProjectController::class, 'upload'])->name('upload')->can('upload', App\Models\ConsultantProject::class);
        Route::delete('{id}', [ConsultantProjectController::class, 'destroy'])->name('destroy')->can('delete', App\Models\ConsultantProject::class);
    });
});
