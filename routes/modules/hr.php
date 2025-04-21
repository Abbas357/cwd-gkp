<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Hr\AclController;
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

Route::prefix('hr')->as('hr.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')->can('viewAny', App\Models\User::class);
        Route::get('/api', [UserController::class, 'users'])->name('api');
        Route::get('/create', [UserController::class, 'create'])->name('create')->can('create', App\Models\User::class);
        Route::get('/current-posting', [UserController::class, 'getCurrentPosting'])->name('current-posting')->can('viewCurrentPosting', App\Models\User::class);

        Route::get('/quick-create', [UserController::class, 'userQuickCreate']);
        Route::post('/quick-store', [UserController::class, 'userQuickStore']);

        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit')->can('update',  'user');
        Route::get('/profile/{uuid}', [UserController::class, 'employee'])->name('employee')->can('viewEmployee', 'user');
        Route::post('/', [UserController::class, 'store'])->name('store')->can('create', App\Models\User::class);
        Route::get('/{user}', [UserController::class, 'show'])->name('show')->can('view', 'user');
        Route::patch('/{user}', [UserController::class, 'update'])->name('update')->can('update', 'user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->can('delete', 'user');
    });

    Route::prefix('offices')->as('offices.')->group(function () {
        Route::get('/', [OfficeController::class, 'index'])->name('index')->can('viewAny', App\Models\Office::class);
        Route::get('/create', [OfficeController::class, 'create'])->name('create')->can('create', App\Models\Office::class);
        Route::get('/api', [OfficeController::class, 'offices'])->name('api');
        Route::post('/', [OfficeController::class, 'store'])->name('store')->can('create', App\Models\Office::class);
        Route::get('/{office}', [OfficeController::class, 'show'])->name('show')->can('view', 'office');
        Route::get('/get/{office}', [OfficeController::class, 'showDetail'])->name('detail')->can('view', 'office');
        Route::patch('/activate/{office}', [OfficeController::class, 'activateOffice'])->name('activate')->can('activate', 'office');
        Route::patch('/update/field/{office}', [OfficeController::class, 'updateField'])->name('updateField')->can('updateField', 'office');
        Route::delete('/{office}', [OfficeController::class, 'destroy'])->name('destroy')->can('delete', 'office');
    });

    Route::prefix('designations')->as('designations.')->group(function () {
        Route::get('/', [DesignationController::class, 'index'])->name('index')->can('viewAny', App\Models\Designation::class);
        Route::get('/create', [DesignationController::class, 'create'])->name('create')->can('create', App\Models\Designation::class);
        Route::post('/', [DesignationController::class, 'store'])->name('store')->can('create', App\Models\Designation::class);
        Route::get('/{designation}', [DesignationController::class, 'show'])->name('show')->can('view', 'designation');
        Route::get('/get/{designation}', [DesignationController::class, 'showDetail'])->name('detail')->can('view', 'designation');
        Route::patch('/activate/{designation}', [DesignationController::class, 'activateDesignation'])->name('activate')->can('activate', 'designation');
        Route::patch('/update/field/{designation}', [DesignationController::class, 'updateField'])->name('updateField')->can('updateField', 'designation');
        Route::delete('/{designation}', [DesignationController::class, 'destroy'])->name('destroy')->can('delete', 'designation');
    });

    Route::prefix('sanctioned-posts')->as('sanctioned-posts.')->group(function () {
        Route::get('/', [SanctionedPostController::class, 'index'])->name('index')->can('viewAny', App\Models\SanctionedPost::class);
        Route::get('/create', [SanctionedPostController::class, 'create'])->name('create')->can('create', App\Models\SanctionedPost::class);
        Route::post('/', [SanctionedPostController::class, 'store'])->name('store')->can('create', App\Models\SanctionedPost::class);
        Route::get('/available-positions', [SanctionedPostController::class, 'getAvailablePositions'])->name('available-positions')->can('viewAvailablePositions', App\Models\SanctionedPost::class);
        Route::post('/quick-create', [SanctionedPostController::class, 'quickCreate'])->name('quick-create');
        Route::get('/check-exists', [SanctionedPostController::class, 'checkExists'])->name('check-exists')->can('checkExists', App\Models\SanctionedPost::class);
        Route::get('/{sanctionedPost}', [SanctionedPostController::class, 'show'])->name('show')->can('view', 'sanctionedPost');
        Route::get('/{sanctionedPost}/edit', [SanctionedPostController::class, 'edit'])->name('edit')->can('update', 'sanctionedPost');
        Route::patch('/{sanctionedPost}', [SanctionedPostController::class, 'update'])->name('update')->can('update', 'sanctionedPost');
        Route::delete('/{sanctionedPost}', [SanctionedPostController::class, 'destroy'])->name('destroy')->can('delete', 'sanctionedPost');
    });

    Route::prefix('postings')->as('postings.')->group(function () {
        Route::get('/', [PostingController::class, 'index'])->name('index')->can('viewAny', App\Models\Posting::class);
        Route::get('/create', [PostingController::class, 'create'])->name('create')->can('create', App\Models\Posting::class);
        Route::post('/check-sanctioned', [PostingController::class, 'checkSanctionedPost'])->name('check-sanctioned')->can('checkSanctioned', App\Models\Posting::class);
        Route::get('/check-occupancy', [PostingController::class, 'checkOccupancy'])->name('check-occupancy')->can('checkOccupancy', App\Models\Posting::class);
        Route::get('/current-officers', [PostingController::class, 'getCurrentOfficers'])->name('current-officers')->can('viewCurrentOfficers', App\Models\Posting::class);
        Route::post('/', [PostingController::class, 'store'])->name('store')->can('create', App\Models\Posting::class);
        Route::get('/{posting}', [PostingController::class, 'show'])->name('show')->can('view', 'posting');
        Route::patch('/{posting}/end', [PostingController::class, 'endPosting'])->name('end')->can('end', 'posting');
        Route::get('/{posting}/edit', [PostingController::class, 'edit'])->name('edit')->can('update', 'posting');
        Route::put('/{posting}', [PostingController::class, 'update'])->name('update')->can('update', 'posting');
        Route::delete('/{posting}', [PostingController::class, 'destroy'])->name('destroy')->can('delete', 'posting');
    });

    Route::prefix('organogram')->as('organogram.')->group(function () {
        Route::get('/', [OrganogramController::class, 'index'])->name('index')->can('viewOrganogram', App\Models\Office::class);
        Route::get('/data', [OrganogramController::class, 'getData'])->name('data')->can('viewOrganogram', App\Models\Office::class);
        Route::get('/user-hierarchy', [OrganogramController::class, 'getUserHierarchy'])->name('user-hierarchy')->can('viewOrganogram', App\Models\Office::class);
    });

    Route::prefix('acl')->as('acl.')->group(function () {
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [AclController::class, 'index'])->name('index')->can('viewAny', Role::class);
            Route::get('/{userId}/data', [AclController::class, 'getUserData'])->name('getUserData')->can('viewAny', Role::class);
            Route::post('/{userId}/roles/{roleId}', [AclController::class, 'assignRoleToUser'])->name('assignRoleToUser')->can('assignRole', Role::class);
            Route::delete('/{userId}/roles/{roleId}', [AclController::class, 'removeRoleFromUser'])->name('removeRoleFromUser')->can('assignRole', Role::class);
            Route::post('/{userId}/permissions/{permissionId}', [AclController::class, 'assignPermissionToUser'])->name('assignPermissionToUser')->can('assignPermission', Role::class);
            Route::delete('/{userId}/permissions/{permissionId}', [AclController::class, 'removePermissionFromUser'])->name('removePermissionFromUser')->can('assignPermission', Role::class);
            Route::get('/filter', [AclController::class, 'filterUsers'])->name('filter')->can('viewAny', Role::class);
            Route::post('/bulk-assign-roles', [AclController::class, 'bulkAssignRoles'])->name('bulkAssignRoles')->can('assignRole', Role::class);
            Route::post('/bulk-assign-permissions', [AclController::class, 'bulkAssignPermissions'])->name('bulkAssignPermissions')->can('assignPermission', Role::class);
            Route::get('/search', [AclController::class, 'searchUsers'])->name('search')->can('viewAny', Role::class);
        });
    
        Route::prefix('permissions')->as('permissions.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index')->can('viewAny', Permission::class);
            Route::post('/', [PermissionController::class, 'store'])->name('store')->can('create', Permission::class);
            Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy')->can('delete', 'permission');
            Route::post('/sync', [PermissionController::class, 'sync'])->name('sync')->can('sync', Permission::class);
        });
    
        Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index')->can('viewAny', Role::class);
            Route::post('/', [RoleController::class, 'store'])->name('store')->can('create', Role::class);
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->can('delete', 'role');
            
            Route::get('/{role}/permissions', [RoleController::class, 'getPermissions'])->name('getPermissions')->can('viewAny', Role::class);
            Route::patch('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('updatePermissions')->can('update', 'role');
            
            Route::post('/{role}/permission', [RoleController::class, 'updateSinglePermission'])->name('updateSinglePermission')->can('update', 'role');
            Route::post('/{role}/permissions/bulk', [RoleController::class, 'bulkUpdatePermissions'])->name('bulkUpdatePermissions')->can('update', 'role');
        });
    });

    Route::prefix('reports')->as('reports.')->group(function () {
        Route::get('/vacancy', [ReportController::class, 'vacancyReport'])->name('vacancy')->can('viewVacancyReport', App\Models\User::class);
        Route::get('/employee-directory', [ReportController::class, 'employeeDirectory'])->name('employees')->can('viewEmployeeDirectoryReport', App\Models\User::class);
        Route::get('/office-strength', [ReportController::class, 'officeStrength'])->name('office-strength')->can('viewOfficeStrengthReport', App\Models\User::class);
        Route::get('/posting-history', [ReportController::class, 'postingHistory'])->name('posting-history')->can('viewPostingHistoryReport', App\Models\User::class);
        Route::get('/service-length', [ReportController::class, 'serviceLengthReport'])->name('service-length')->can('viewServiceLengthReport', App\Models\User::class);
        Route::get('/retirement-forecast', [ReportController::class, 'retirementForecast'])->name('retirement-forecast')->can('viewRetirementForecastReport', App\Models\User::class);
        Route::get('/office-staff', [ReportController::class, 'officeStaff'])->name('office-staff')->can('viewOfficeStaffReport', App\Models\User::class);
    });
    
});