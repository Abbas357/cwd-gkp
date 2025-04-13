<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hr\RoleController;
use App\Http\Controllers\Hr\UserController;
use App\Http\Controllers\Hr\OfficeController;
use App\Http\Controllers\Hr\ReportController;
use App\Http\Controllers\Hr\PostingController;
use App\Http\Controllers\Hr\DashboardController;
use App\Http\Controllers\Hr\OrganogramController;
use App\Http\Controllers\Hr\PermissionController;
use App\Http\Controllers\Hr\DesignationController;
use App\Http\Controllers\Hr\SanctionedPostController;

Route::prefix('hr')->as('hr.')->middleware(['can:manage human resource'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/org-chart', [DashboardController::class, 'ogChart'])->name('org-chart');
    Route::get('/office-hierarchy', [DashboardController::class, 'getOfficeHierarchy'])->name('office-hierarchy');
    Route::get('/user-relationships', [DashboardController::class, 'getUserReportingRelationships'])->name('user-relationships');

    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')->can('viewAny', App\Models\User::class);
        Route::get('/api', [UserController::class, 'users'])->name('api')->withoutMiddleware(['can:manage human resource']);
        Route::get('/create', [UserController::class, 'create'])->name('create')->can('create', App\Models\User::class);
        Route::get('/current-posting', [UserController::class, 'getCurrentPosting'])->name('current-posting');

        Route::get('/quick-create', [UserController::class, 'userQuickCreate'])->name('quick-create')->withoutMiddleware(['can:manage human resource']);
        Route::post('/quick-store', [UserController::class, 'userQuickStore'])->name('quick-store')->withoutMiddleware(['can:manage human resource']);

        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit')->can('update',  'user');
        Route::get('/profile/{uuid}', [UserController::class, 'employee'])->name('employee')->can('view', 'user');
        Route::patch('/activate/{user}', [UserController::class, 'activateUser'])->name('activate')->can('activate', 'user');
        Route::patch('/archive/{user}', [UserController::class, 'archiveUser'])->name('archive')->can('archive', 'user');
        Route::post('/', [UserController::class, 'store'])->name('store')->can('create', App\Models\User::class);
        Route::get('/{user}', [UserController::class, 'show'])->name('show')->can('view', 'user');
        Route::patch('/{user}', [UserController::class, 'update'])->name('update')->can('update', 'user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->can('delete', 'user');
    });

    Route::prefix('offices')->as('offices.')->group(function () {
        Route::get('/', [OfficeController::class, 'index'])->name('index')->can('viewAny', App\Models\Office::class);
        Route::get('/create', [OfficeController::class, 'create'])->name('create')->can('create', App\Models\Office::class);
        Route::get('/district', [OfficeController::class, 'getOfficeDistrict'])->name('district');
        Route::get('/api', [OfficeController::class, 'offices'])->name('api')->withoutMiddleware(['can:manage human resource']);
        Route::post('/', [OfficeController::class, 'store'])->name('store')->can('create', App\Models\Office::class);
        Route::get('/{office}', [OfficeController::class, 'show'])->name('show')->can('view', 'office');
        Route::get('/get/{office}', [OfficeController::class, 'showDetail'])->name('detail')->can('view', 'office');
        Route::patch('/activate/{office}', [OfficeController::class, 'activateOffice'])->name('activate')->can('activate', 'office');
        Route::patch('/update/field/{office}', [OfficeController::class, 'updateField'])->name('updateField')->can('update', 'office');
        Route::delete('/{office}', [OfficeController::class, 'destroy'])->name('destroy')->can('delete', 'office');
    });

    Route::prefix('designations')->as('designations.')->group(function () {
        Route::get('/', [DesignationController::class, 'index'])->name('index')->can('viewAny', App\Models\Designation::class);
        Route::get('/create', [DesignationController::class, 'create'])->name('create')->can('create', App\Models\Designation::class);
        Route::post('/', [DesignationController::class, 'store'])->name('store')->can('create', App\Models\Designation::class);
        Route::get('/{designation}', [DesignationController::class, 'show'])->name('show')->can('view', 'designation');
        Route::get('/get/{designation}', [DesignationController::class, 'showDetail'])->name('detail')->can('view', 'designation');
        Route::patch('/activate/{designation}', [DesignationController::class, 'activateDesignation'])->name('activate')->can('activate', 'designation');
        Route::patch('/update/field/{designation}', [DesignationController::class, 'updateField'])->name('updateField')->can('update', 'designation');
        Route::delete('/{designation}', [DesignationController::class, 'destroy'])->name('destroy')->can('delete', 'designation');
    });

    Route::prefix('sanctioned-posts')->as('sanctioned-posts.')->group(function () {
        Route::get('/', [SanctionedPostController::class, 'index'])->name('index');
        Route::get('/create', [SanctionedPostController::class, 'create'])->name('create');
        Route::post('/', [SanctionedPostController::class, 'store'])->name('store');
        Route::get('/available-positions', [SanctionedPostController::class, 'getAvailablePositions'])->name('available-positions');
        Route::post('/quick-create', [SanctionedPostController::class, 'quickCreate'])->name('quick-create');
        Route::get('/check-exists', [SanctionedPostController::class, 'checkExists'])->name('check-exists');
        Route::get('/{sanctionedPost}', [SanctionedPostController::class, 'show'])->name('show');
        Route::get('/{sanctionedPost}/edit', [SanctionedPostController::class, 'edit'])->name('edit');
        Route::patch('/{sanctionedPost}', [SanctionedPostController::class, 'update'])->name('update');
        Route::delete('/{sanctionedPost}', [SanctionedPostController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('postings')->as('postings.')->group(function () {
        Route::get('/', [PostingController::class, 'index'])->name('index');
        Route::get('/create', [PostingController::class, 'create'])->name('create');
        Route::post('/check-sanctioned', [PostingController::class, 'checkSanctionedPost'])->name('check-sanctioned');
        Route::get('/check-occupancy', [PostingController::class, 'checkOccupancy'])->name('check-occupancy');
        Route::get('/current-officers', [PostingController::class, 'getCurrentOfficers'])->name('current-officers');
        Route::post('/', [PostingController::class, 'store'])->name('store');
        Route::get('/{posting}', [PostingController::class, 'show'])->name('show');
        Route::patch('/{posting}/end', [PostingController::class, 'endPosting'])->name('end');
        Route::get('/{posting}/edit', [PostingController::class, 'edit'])->name('edit');
        Route::put('/{posting}', [PostingController::class, 'update'])->name('update');
        Route::delete('/{posting}', [PostingController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('organogram')->as('organogram.')->group(function () {
        Route::get('/', [OrganogramController::class, 'index'])->name('index');
        Route::get('/data', [OrganogramController::class, 'getData'])->name('data');
        Route::get('/user-hierarchy', [OrganogramController::class, 'getUserHierarchy'])->name('user-hierarchy');
    });

    Route::prefix('roles')->as('roles.')->group(function () {
        // Existing routes
        Route::get('/', [RoleController::class, 'index'])->name('index')->can('viewAny', Spatie\Permission\Models\Role::class);
        Route::post('/', [RoleController::class, 'store'])->name('store')->can('create', Spatie\Permission\Models\Role::class);
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->can('delete', 'role');
        Route::get('/{role}/permissions', [RoleController::class, 'getPermissions'])->name('getPermissions')->can('update', Spatie\Permission\Models\Role::class);
        Route::patch('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('updatePermissions')->can('update', Spatie\Permission\Models\Role::class);
        
        // New routes for user role management
        Route::get('/{userId}/data', [RoleController::class, 'getUserData'])->name('getUserData');
        Route::post('/users/{userId}/roles/{roleId}', [RoleController::class, 'assignRoleToUser'])->name('assignRoleToUser');
        Route::delete('/users/{userId}/roles/{roleId}', [RoleController::class, 'removeRoleFromUser'])->name('removeRoleFromUser');
        Route::post('/users/{userId}/permissions/{permissionId}', [RoleController::class, 'assignPermissionToUser'])->name('assignPermissionToUser');
        Route::delete('/users/{userId}/permissions/{permissionId}', [RoleController::class, 'removePermissionFromUser'])->name('removePermissionFromUser');
        Route::get('/filter-users', [RoleController::class, 'filterUsers'])->name('filterUsers');
        Route::post('/bulk-assign-roles', [RoleController::class, 'bulkAssignRoles'])->name('bulkAssignRoles');
        Route::post('/bulk-assign-permissions', [RoleController::class, 'bulkAssignPermissions'])->name('bulkAssignPermissions');
    });

    Route::prefix('permissions')->as('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index')->can('viewAny', Spatie\Permission\Models\Permission::class);
        Route::post('/', [PermissionController::class, 'store'])->name('store')->can('create', Spatie\Permission\Models\Permission::class);
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy')->can('delete', 'permission');
        Route::post('/sync', [PermissionController::class, 'sync'])->name('sync')->can('sync', 'permission');
    });

    Route::prefix('reports')->as('reports.')->group(function () {
        Route::get('/vacancy', [ReportController::class, 'vacancyReport'])->name('vacancy');
        Route::get('/employee-directory', [ReportController::class, 'employeeDirectory'])->name('employees');
        Route::get('/office-strength', [ReportController::class, 'officeStrength'])->name('office-strength');
        Route::get('/posting-history', [ReportController::class, 'postingHistory'])->name('posting-history');
        Route::get('/service-length', [ReportController::class, 'serviceLengthReport'])->name('service-length');
        Route::get('/retirement-forecast', [ReportController::class, 'retirementForecast'])->name('retirement-forecast');
        Route::get('/office-staff', [ReportController::class, 'officeStaff'])->name('office-staff');
    });
    
});
