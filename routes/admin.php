<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\SeniorityController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProjectFileController;
use App\Http\Controllers\ServiceCardController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\EStandardizationController;
use App\Http\Controllers\DevelopmentProjectController;
use App\Http\Controllers\ContractorRegistrationController;

Route::middleware('auth')->group(function () { 
    Route::prefix('admin')->as('admin.')->group(function () {

        Route::prefix('profile')->as('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });
 
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/api', [UserController::class, 'users'])->name('api');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/activate/{user}', [UserController::class, 'activateUser'])->name('activate');
            Route::patch('/archive/{user}', [UserController::class, 'archiveUser'])->name('archive');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::patch('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('service_cards')->as('service_cards.')->group(function () {            
            Route::get('/', [ServiceCardController::class, 'index'])->name('index');
            Route::get('/{id}', [ServiceCardController::class, 'show'])->name('show');
            Route::get('/get/{id}', [ServiceCardController::class, 'showDetail'])->name('detail');
            Route::get('/card/{id}', [ServiceCardController::class, 'showCard'])->name('showCard');
            Route::patch('/verify/{id}', [ServiceCardController::class, 'verify'])->name('verify');
            Route::patch('/reject/{id}', [ServiceCardController::class, 'reject'])->name('reject');
            Route::patch('/restore/{id}', [ServiceCardController::class, 'restore'])->name('restore');
            Route::patch('/renew/{id}', [ServiceCardController::class, 'renew'])->name('renew');
            Route::patch('/update/field', [ServiceCardController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [ServiceCardController::class, 'uploadFile'])->name('uploadFile');
        });

        Route::prefix('registrations')->as('registrations.')->group(function () {
            Route::get('/', [ContractorRegistrationController::class, 'index'])->name('index');
            Route::patch('/defer/{ContractorRegistration}', [ContractorRegistrationController::class, 'defer'])->name('defer');
            Route::patch('/approve/{ContractorRegistration}', [ContractorRegistrationController::class, 'approve'])->name('approve');
            Route::get('/{ContractorRegistration}', [ContractorRegistrationController::class, 'show'])->name('show');
            Route::get('/get/{ContractorRegistration}', [ContractorRegistrationController::class, 'showDetail'])->name('showDetail');
            Route::get('/card/{ContractorRegistration}', [ContractorRegistrationController::class, 'showCard'])->name('showCard');
            Route::patch('/renew/{ContractorRegistration}', [ContractorRegistrationController::class, 'renew'])->name('renew');
            Route::patch('/update-field', [ContractorRegistrationController::class, 'updateField'])->name('updateField');
            Route::patch('/upload-file', [ContractorRegistrationController::class, 'uploadFile'])->name('uploadFile');
        });

        Route::prefix('standardizations')->as('standardizations.')->group(function () {
            Route::get('/', [EStandardizationController::class, 'index'])->name('index');
            Route::patch('/approve/{EStandardization}', [EStandardizationController::class, 'approve'])->name('approve');
            Route::patch('/reject/{EStandardization}', [EStandardizationController::class, 'reject'])->name('reject');
            Route::get('/{EStandardization}', [EStandardizationController::class, 'show'])->name('show');
            Route::get('/get/{EStandardization}', [EStandardizationController::class, 'showDetail'])->name('detail');
            Route::get('/card/{EStandardization}', [EStandardizationController::class, 'showCard'])->name('card');
            Route::patch('/renew/{EStandardization}', [EStandardizationController::class, 'renew'])->name('renew');
            Route::patch('/update/field', [EStandardizationController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [EStandardizationController::class, 'uploadFile'])->name('uploadFile');
        });

        Route::prefix('downloads')->as('downloads.')->group(function () {
            Route::get('/', [DownloadController::class, 'index'])->name('index');
            Route::get('/create', [DownloadController::class, 'create'])->name('create');
            Route::post('/', [DownloadController::class, 'store'])->name('store');
            Route::get('/{download}', [DownloadController::class, 'show'])->name('show');
            Route::get('/get/{download}', [DownloadController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{download}', [DownloadController::class, 'publishDownload'])->name('publish');
            Route::patch('/archive/{download}', [DownloadController::class, 'archiveDownload'])->name('archive');
            Route::patch('/update/field', [DownloadController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [DownloadController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{download}', [DownloadController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('events')->as('events.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/create', [EventController::class, 'create'])->name('create');
            Route::post('/', [EventController::class, 'store'])->name('store');
            Route::get('/{event}', [EventController::class, 'show'])->name('show');
            Route::get('/get/{event}', [EventController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{event}', [EventController::class, 'publishEvent'])->name('publish');
            Route::patch('/archive/{event}', [EventController::class, 'archiveEvent'])->name('archive');
            Route::patch('/update/field', [EventController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [EventController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('gallery')->as('gallery.')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::get('/create', [GalleryController::class, 'create'])->name('create');
            Route::post('/', [GalleryController::class, 'store'])->name('store');
            Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show');
            Route::get('/get/{gallery}', [GalleryController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{gallery}', [GalleryController::class, 'publishGallery'])->name('publish');
            Route::patch('/archive/{gallery}', [GalleryController::class, 'archiveGallery'])->name('archive');
            Route::patch('/update/field', [GalleryController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [GalleryController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('newsletter')->as('newsletter.')->group(function () {
            Route::get('/', [NewsLetterController::class, 'index'])->name('index');
            Route::get('/mass-email', [NewsLetterController::class, 'createMassEmail'])->name('create_mass_email');
            Route::post('/mass-email', [NewsLetterController::class, 'sendMassEmail'])->name('send_mass_email');
        });

        Route::prefix('public_contact')->as('public_contact.')->group(function () {
            Route::get('/', [PublicContactController::class, 'index'])->name('index');
            Route::patch('/relief-grant/{PublicContact}', [PublicContactController::class, 'reliefGrant'])->name('grant');
            Route::patch('/relief-not-grant/{PublicContact}', [PublicContactController::class, 'reliefNotGrant'])->name('notgrant');
            Route::patch('/drop/{PublicContact}', [PublicContactController::class, 'drop'])->name('drop');
        });

        Route::prefix('news')->as('news.')->group(function () {
            Route::get('/', [NewsController::class, 'index'])->name('index');
            Route::get('/create', [NewsController::class, 'create'])->name('create');
            Route::post('/', [NewsController::class, 'store'])->name('store');
            Route::get('/{news}', [NewsController::class, 'show'])->name('show');
            Route::get('/get/{news}', [NewsController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{news}', [NewsController::class, 'publishNews'])->name('publish');
            Route::patch('/archive/{news}', [NewsController::class, 'archiveNews'])->name('archive');
            Route::patch('/update/field', [NewsController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [NewsController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('seniority')->as('seniority.')->group(function () {
            Route::get('/', [SeniorityController::class, 'index'])->name('index');
            Route::get('/create', [SeniorityController::class, 'create'])->name('create');
            Route::post('/', [SeniorityController::class, 'store'])->name('store');
            Route::get('/{seniority}', [SeniorityController::class, 'show'])->name('show');
            Route::get('/get/{seniority}', [SeniorityController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{seniority}', [SeniorityController::class, 'publishSeniority'])->name('publish');
            Route::patch('/archive/{seniority}', [SeniorityController::class, 'archiveSeniority'])->name('archive');
            Route::patch('/update/field', [SeniorityController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [SeniorityController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{seniority}', [SeniorityController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('development_projects')->as('development_projects.')->group(function () {
            Route::get('/', [DevelopmentProjectController::class, 'index'])->name('index');
            Route::get('/create', [DevelopmentProjectController::class, 'create'])->name('create');
            Route::post('/', [DevelopmentProjectController::class, 'store'])->name('store');
            Route::get('/{DevelopmentProject}', [DevelopmentProjectController::class, 'show'])->name('show');
            Route::get('/get/{DevelopmentProject}', [DevelopmentProjectController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{DevelopmentProject}', [DevelopmentProjectController::class, 'publishDevelopmentProject'])->name('publish');
            Route::patch('/archive/{DevelopmentProject}', [DevelopmentProjectController::class, 'archiveDevelopmentProject'])->name('archive');
            Route::patch('/update/field', [DevelopmentProjectController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [DevelopmentProjectController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{DevelopmentProject}', [DevelopmentProjectController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('projects')->as('projects.')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('index');
            Route::get('/create', [ProjectController::class, 'create'])->name('create');
            Route::post('/', [ProjectController::class, 'store'])->name('store');
            Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
            Route::get('/get/{project}', [ProjectController::class, 'showDetail'])->name('detail');
            Route::patch('/update/field', [ProjectController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [ProjectController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('project_files')->as('project_files.')->group(function () {
            Route::get('/', [ProjectFileController::class, 'index'])->name('index');
            Route::get('/create', [ProjectFileController::class, 'create'])->name('create');
            Route::post('/', [ProjectFileController::class, 'store'])->name('store');
            Route::get('/{project_file}', [ProjectFileController::class, 'show'])->name('show');
            Route::get('/get/{project_file}', [ProjectFileController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{project_file}', [ProjectFileController::class, 'publishProjectFile'])->name('publish');
            Route::patch('/archive/{project_file}', [ProjectFileController::class, 'archiveProjectFile'])->name('archive');
            Route::patch('/update/field', [ProjectFileController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [ProjectFileController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{project_file}', [ProjectFileController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('sliders')->as('sliders.')->group(function () {
            Route::get('/', [SliderController::class, 'index'])->name('index');
            Route::get('/create', [SliderController::class, 'create'])->name('create');
            Route::post('/', [SliderController::class, 'store'])->name('store');
            Route::get('/{slider}', [SliderController::class, 'show'])->name('show');
            Route::get('/get/{slider}', [SliderController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{slider}', [SliderController::class, 'publishSlider'])->name('publish');
            Route::patch('/archive/{slider}', [SliderController::class, 'archiveSlider'])->name('archive');
            Route::patch('/update/field', [SliderController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [SliderController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pages')->as('pages.')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('index');
            Route::get('/create', [PageController::class, 'create'])->name('create');
            Route::post('/', [PageController::class, 'store'])->name('store');
            Route::get('/{page}', [PageController::class, 'show'])->name('show');
            Route::get('/get/{page}', [PageController::class, 'showDetail'])->name('detail');
            Route::patch('/activate/{page}', [PageController::class, 'activatePage'])->name('activate');
            Route::patch('/update/field', [PageController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [PageController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{page}', [PageController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('stories')->as('stories.')->group(function () {
            Route::get('/', [StoryController::class, 'index'])->name('index');
            Route::get('/create', [StoryController::class, 'create'])->name('create');
            Route::post('/', [StoryController::class, 'store'])->name('store');
            Route::patch('/publish/{story}', [StoryController::class, 'publishStory'])->name('publish');
            Route::get('/{story}', [StoryController::class, 'show'])->name('show');
            Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('tenders')->as('tenders.')->group(function () {
            Route::get('/', [TenderController::class, 'index'])->name('index');
            Route::get('/create', [TenderController::class, 'create'])->name('create');
            Route::post('/', [TenderController::class, 'store'])->name('store');
            Route::get('/{tender}', [TenderController::class, 'show'])->name('show');
            Route::get('/get/{tender}', [TenderController::class, 'showDetail'])->name('detail');
            Route::patch('/publish/{tender}', [TenderController::class, 'publishTender'])->name('publish');
            Route::patch('/archive/{tender}', [TenderController::class, 'archiveTender'])->name('archive');
            Route::patch('/update/field', [TenderController::class, 'updateField'])->name('updateField');
            Route::patch('/upload/file', [TenderController::class, 'uploadFile'])->name('uploadFile');
            Route::delete('/{tender}', [TenderController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('schemes')->as('schemes.')->group(function () {
            Route::get('/', [SchemeController::class, 'index'])->name('index');
            Route::post('/sync', [SchemeController::class, 'syncSchemes'])->name('sync');
        });
        
        Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');

            Route::get('/{role}/permissions', [RoleController::class, 'getPermissions'])->name('getPermissions');
            Route::patch('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('updatePermissions');
        });

        Route::prefix('permissions')->as('permissions.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('settings')->as('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::patch('/', [SettingController::class, 'update'])->name('update');
        });

        Route::prefix('categories')->as('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('districts')->as('districts.')->group(function () {
            Route::get('/', [DistrictController::class, 'index'])->name('index');
            Route::post('/', [DistrictController::class, 'store'])->name('store');
            Route::delete('/{district}', [DistrictController::class, 'destroy'])->name('destroy');
        });

        Route::get('/logs', ActivityLogController::class)->name('logs');
    });
});