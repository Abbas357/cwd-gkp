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
use App\Http\Controllers\CommentController;
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
        });
 
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index')->can('viewAny', App\Models\User::class);
            Route::get('/api', [UserController::class, 'users'])->name('api');
            Route::get('/create', [UserController::class, 'create'])->name('create')->can('create', App\Models\User::class);
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit')->can('update',  'user');
            Route::patch('/activate/{user}', [UserController::class, 'activateUser'])->name('activate')->can('activate', 'user');
            Route::patch('/archive/{user}', [UserController::class, 'archiveUser'])->name('archive')->can('archive', 'user');
            Route::post('/', [UserController::class, 'store'])->name('store')->can('create', App\Models\User::class);
            Route::get('/{user}', [UserController::class, 'show'])->name('show')->can('view', 'user');
            Route::patch('/{user}', [UserController::class, 'update'])->name('update')->can('update', 'user');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->can('delete', 'user');
        });

        Route::prefix('service_cards')->as('service_cards.')->group(function () {            
            Route::get('/', [ServiceCardController::class, 'index'])->name('index')->can('viewAny', App\Models\ServiceCard::class);
            Route::get('/{service_card}', [ServiceCardController::class, 'show'])->name('show')->can('view', App\Models\ServiceCard::class);
            Route::get('/get/{service_card}', [ServiceCardController::class, 'showDetail'])->name('detail')->can('view', 'service_card');
            Route::get('/card/{service_card}', [ServiceCardController::class, 'showCard'])->name('showCard')->can('view', 'service_card');
            Route::patch('/verify/{service_card}', [ServiceCardController::class, 'verify'])->name('verify')->can('verify', 'service_card');
            Route::patch('/reject/{service_card}', [ServiceCardController::class, 'reject'])->name('reject')->can('reject', 'service_card');
            Route::patch('/restore/{service_card}', [ServiceCardController::class, 'restore'])->name('restore')->can('restore', 'service_card');
            Route::patch('/renew/{service_card}', [ServiceCardController::class, 'renew'])->name('renew')->can('renew', 'service_card');
            Route::patch('/update/field/{service_card}', [ServiceCardController::class, 'updateField'])->name('updateField')->can('update', 'service_card');
            Route::patch('/upload/file/{service_card}', [ServiceCardController::class, 'uploadFile'])->name('uploadFile')->can('update', 'service_card');
        });
        
        Route::prefix('registrations')->as('registrations.')->group(function () {
            Route::get('/', [ContractorRegistrationController::class, 'index'])->name('index')->can('viewAny', App\Models\ContractorRegistration::class);
            Route::patch('/defer/{ContractorRegistration}', [ContractorRegistrationController::class, 'defer'])->name('defer')->can('defer', 'ContractorRegistration');
            Route::patch('/approve/{ContractorRegistration}', [ContractorRegistrationController::class, 'approve'])->name('approve')->can('approve', 'ContractorRegistration');
            Route::get('/{ContractorRegistration}', [ContractorRegistrationController::class, 'show'])->name('show')->can('view', 'ContractorRegistration');
            Route::get('/get/{ContractorRegistration}', [ContractorRegistrationController::class, 'showDetail'])->name('showDetail')->can('view', 'ContractorRegistration');
            Route::get('/card/{ContractorRegistration}', [ContractorRegistrationController::class, 'showCard'])->name('showCard')->can('card', 'ContractorRegistration');
            Route::patch('/renew/{ContractorRegistration}', [ContractorRegistrationController::class, 'renew'])->name('renew')->can('renew', 'ContractorRegistration');
            Route::patch('/update/field/{ContractorRegistration}', [ContractorRegistrationController::class, 'updateField'])->name('updateField')->can('update', 'ContractorRegistration');
            Route::patch('/update/file/{ContractorRegistration}', [ContractorRegistrationController::class, 'uploadFile'])->name('uploadFile')->can('update', 'ContractorRegistration');
        });
        
        Route::prefix('standardizations')->as('standardizations.')->group(function () {
            Route::get('/', [EStandardizationController::class, 'index'])->name('index')->can('viewAny', App\Models\EStandardization::class);
            Route::patch('/approve/{EStandardization}', [EStandardizationController::class, 'approve'])->name('approve')->can('approve', 'EStandardization');
            Route::patch('/reject/{EStandardization}', [EStandardizationController::class, 'reject'])->name('reject')->can('reject', 'EStandardization');
            Route::get('/{EStandardization}', [EStandardizationController::class, 'show'])->name('show')->can('view', 'EStandardization');
            Route::get('/get/{EStandardization}', [EStandardizationController::class, 'showDetail'])->name('detail')->can('view', 'EStandardization');
            Route::get('/card/{EStandardization}', [EStandardizationController::class, 'showCard'])->name('card')->can('card', 'EStandardization');
            Route::patch('/renew/{EStandardization}', [EStandardizationController::class, 'renew'])->name('renew')->can('renew', 'EStandardization');
            Route::patch('/update/field/{EStandardization}', [EStandardizationController::class, 'updateField'])->name('updateField')->can('update', 'EStandardization');
            Route::patch('/upload/file/{EStandardization}', [EStandardizationController::class, 'uploadFile'])->name('uploadFile')->can('update', 'EStandardization');
        });
        
        Route::prefix('downloads')->as('downloads.')->group(function () {
            Route::get('/', [DownloadController::class, 'index'])->name('index')->can('viewAny', App\Models\Download::class);
            Route::get('/create', [DownloadController::class, 'create'])->name('create')->can('create', App\Models\Download::class);
            Route::post('/', [DownloadController::class, 'store'])->name('store')->can('create', App\Models\Download::class);
            Route::get('/{download}', [DownloadController::class, 'show'])->name('show')->can('view', 'download');
            Route::get('/get/{download}', [DownloadController::class, 'showDetail'])->name('detail')->can('view', 'download');
            Route::patch('/publish/{download}', [DownloadController::class, 'publishDownload'])->name('publish')->can('publish', 'download');
            Route::patch('/archive/{download}', [DownloadController::class, 'archiveDownload'])->name('archive')->can('archive', 'download');
            Route::patch('/update/field/{download}', [DownloadController::class, 'updateField'])->name('updateField')->can('update', 'download');
            Route::patch('/upload/file/{download}', [DownloadController::class, 'uploadFile'])->name('uploadFile')->can('update', 'download');
            Route::delete('/{download}', [DownloadController::class, 'destroy'])->name('destroy')->can('delete', 'download');
        });
        
        Route::prefix('events')->as('events.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index')->can('viewAny', App\Models\Event::class);
            Route::get('/create', [EventController::class, 'create'])->name('create')->can('create', App\Models\Event::class);
            Route::post('/', [EventController::class, 'store'])->name('store')->can('create', App\Models\Event::class);
            Route::get('/{event}', [EventController::class, 'show'])->name('show')->can('view', 'event');
            Route::get('/get/{event}', [EventController::class, 'showDetail'])->name('detail')->can('view', 'event');
            Route::patch('/publish/{event}', [EventController::class, 'publishEvent'])->name('publish')->can('publish', 'event');
            Route::patch('/archive/{event}', [EventController::class, 'archiveEvent'])->name('archive')->can('archive', 'event');
            Route::patch('/update/field/{event}', [EventController::class, 'updateField'])->name('updateField')->can('update', 'event');
            Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy')->can('delete', 'event');
        });
        
        Route::prefix('gallery')->as('gallery.')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index')->can('viewAny', App\Models\Gallery::class);
            Route::get('/create', [GalleryController::class, 'create'])->name('create')->can('create', App\Models\Gallery::class);
            Route::post('/', [GalleryController::class, 'store'])->name('store')->can('create', App\Models\Gallery::class);
            Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show')->can('view', 'gallery');
            Route::get('/get/{gallery}', [GalleryController::class, 'showDetail'])->name('detail')->can('view', 'gallery');
            Route::patch('/publish/{gallery}', [GalleryController::class, 'publishGallery'])->name('publish')->can('publish', 'gallery');
            Route::patch('/archive/{gallery}', [GalleryController::class, 'archiveGallery'])->name('archive')->can('archive', 'gallery');
            Route::patch('/update/field/{gallery}', [GalleryController::class, 'updateField'])->name('updateField')->can('update', 'gallery');
            Route::patch('/upload/file/{gallery}', [GalleryController::class, 'uploadFile'])->name('uploadFile')->can('update', 'gallery');
            Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy')->can('delete', 'gallery');
        });
        
        Route::prefix('newsletter')->as('newsletter.')->group(function () {
            Route::get('/', [NewsLetterController::class, 'index'])->name('index')->can('viewAny', App\Models\NewsLetter::class);
            Route::get('/mass-email', [NewsLetterController::class, 'createMassEmail'])->name('create_mass_email')->can('sendMassEmail', App\Models\NewsLetter::class);
            Route::post('/mass-email', [NewsLetterController::class, 'sendMassEmail'])->name('send_mass_email')->can('sendMassEmail', App\Models\NewsLetter::class);
        });
        
        Route::prefix('public_contact')->as('public_contact.')->group(function () {
            Route::get('/', [PublicContactController::class, 'index'])->name('index')->can('viewAny', App\Models\PublicContact::class);
            Route::get('/get/{PublicContact}', [PublicContactController::class, 'showDetail'])->name('detail')->can('view', App\Models\PublicContact::class);
            Route::patch('/relief-grant/{PublicContact}', [PublicContactController::class, 'reliefGrant'])->name('grant')->can('reliefGrant', App\Models\PublicContact::class);
            Route::patch('/relief-not-grant/{PublicContact}', [PublicContactController::class, 'reliefNotGrant'])->name('notgrant')->can('reliefNotGrant', App\Models\PublicContact::class);
            Route::patch('/drop/{PublicContact}', [PublicContactController::class, 'drop'])->name('drop')->can('drop', App\Models\PublicContact::class);
        });
        
        Route::prefix('news')->as('news.')->group(function () {
            Route::get('/', [NewsController::class, 'index'])->name('index')->can('viewAny', App\Models\News::class);
            Route::get('/create', [NewsController::class, 'create'])->name('create')->can('create', App\Models\News::class);
            Route::post('/', [NewsController::class, 'store'])->name('store')->can('create', App\Models\News::class);
            Route::get('/{news}', [NewsController::class, 'show'])->name('show')->can('view', 'news');
            Route::get('/get/{news}', [NewsController::class, 'showDetail'])->name('detail')->can('view', 'news');
            Route::patch('/publish/{news}', [NewsController::class, 'publishNews'])->name('publish')->can('publish', 'news');
            Route::patch('/archive/{news}', [NewsController::class, 'archiveNews'])->name('archive')->can('archive', 'news');
            Route::patch('/update/field/{news}', [NewsController::class, 'updateField'])->name('updateField')->can('update', 'news');
            Route::patch('/upload/file/{news}', [NewsController::class, 'uploadFile'])->name('uploadFile')->can('update', 'news');
            Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy')->can('delete', 'news');
        });
        
        Route::prefix('seniority')->as('seniority.')->group(function () {
            Route::get('/', [SeniorityController::class, 'index'])->name('index')->can('viewAny', App\Models\Seniority::class);
            Route::get('/create', [SeniorityController::class, 'create'])->name('create')->can('create', App\Models\Seniority::class);
            Route::post('/', [SeniorityController::class, 'store'])->name('store')->can('create', App\Models\Seniority::class);
            Route::get('/{seniority}', [SeniorityController::class, 'show'])->name('show')->can('view', 'seniority');
            Route::get('/get/{seniority}', [SeniorityController::class, 'showDetail'])->name('detail')->can('view', 'seniority');
            Route::patch('/publish/{seniority}', [SeniorityController::class, 'publishSeniority'])->name('publish')->can('publish', 'seniority');
            Route::patch('/archive/{seniority}', [SeniorityController::class, 'archiveSeniority'])->name('archive')->can('archive', 'seniority');
            Route::patch('/update/field/{seniority}', [SeniorityController::class, 'updateField'])->name('updateField')->can('update', 'seniority');
            Route::patch('/upload/file/{seniority}', [SeniorityController::class, 'uploadFile'])->name('uploadFile')->can('update', 'seniority');
            Route::delete('/{seniority}', [SeniorityController::class, 'destroy'])->name('destroy')->can('delete', 'seniority');
        });
        
        Route::prefix('development_projects')->as('development_projects.')->group(function () {
            Route::get('/', [DevelopmentProjectController::class, 'index'])->name('index')->can('viewAny', App\Models\DevelopmentProject::class);
            Route::get('/create', [DevelopmentProjectController::class, 'create'])->name('create')->can('create', App\Models\DevelopmentProject::class);
            Route::post('/', [DevelopmentProjectController::class, 'store'])->name('store')->can('create', App\Models\DevelopmentProject::class);
            Route::get('/{DevelopmentProject}', [DevelopmentProjectController::class, 'show'])->name('show')->can('view', 'DevelopmentProject');
            Route::get('/get/{DevelopmentProject}', [DevelopmentProjectController::class, 'showDetail'])->name('detail')->can('view', 'DevelopmentProject');
            Route::patch('/publish/{DevelopmentProject}', [DevelopmentProjectController::class, 'publishDevelopmentProject'])->name('publish')->can('publish', 'DevelopmentProject');
            Route::patch('/archive/{DevelopmentProject}', [DevelopmentProjectController::class, 'archiveDevelopmentProject'])->name('archive')->can('archive', 'DevelopmentProject');
            Route::patch('/update/field/{DevelopmentProject}', [DevelopmentProjectController::class, 'updateField'])->name('updateField')->can('update', 'DevelopmentProject');
            Route::delete('/{DevelopmentProject}', [DevelopmentProjectController::class, 'destroy'])->name('destroy')->can('delete', 'DevelopmentProject');
        });
        
        Route::prefix('projects')->as('projects.')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('index')->can('viewAny', App\Models\Project::class);
            Route::get('/create', [ProjectController::class, 'create'])->name('create')->can('create', App\Models\Project::class);
            Route::post('/', [ProjectController::class, 'store'])->name('store')->can('create', App\Models\Project::class);
            Route::get('/{project}', [ProjectController::class, 'show'])->name('show')->can('view', 'project');
            Route::get('/get/{project}', [ProjectController::class, 'showDetail'])->name('detail')->can('view', 'project');
            Route::patch('/update/field/{project}', [ProjectController::class, 'updateField'])->name('updateField')->can('update', 'project');
            Route::patch('/upload/file/{project}', [ProjectController::class, 'uploadFile'])->name('uploadFile')->can('update', 'project');
            Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy')->can('delete', 'project');
        });
        
        Route::prefix('project_files')->as('project_files.')->group(function () {
            Route::get('/', [ProjectFileController::class, 'index'])->name('index')->can('viewAny', App\Models\ProjectFile::class);
            Route::get('/create', [ProjectFileController::class, 'create'])->name('create')->can('create', App\Models\ProjectFile::class);
            Route::post('/', [ProjectFileController::class, 'store'])->name('store')->can('create', App\Models\ProjectFile::class);
            Route::get('/{project_file}', [ProjectFileController::class, 'show'])->name('show')->can('view', 'project_file');
            Route::get('/get/{project_file}', [ProjectFileController::class, 'showDetail'])->name('detail')->can('view', 'project_file');
            Route::patch('/publish/{project_file}', [ProjectFileController::class, 'publishProjectFile'])->name('publish')->can('publish', 'project_file');
            Route::patch('/archive/{project_file}', [ProjectFileController::class, 'archiveProjectFile'])->name('archive')->can('archive', 'project_file');
            Route::patch('/update/field/{project_file}', [ProjectFileController::class, 'updateField'])->name('updateField')->can('update', 'project_file');
            Route::patch('/upload/file/{project_file}', [ProjectFileController::class, 'uploadFile'])->name('uploadFile')->can('update', 'project_file');
            Route::delete('/{project_file}', [ProjectFileController::class, 'destroy'])->name('destroy')->can('delete', 'project_file');
        });
        
        Route::prefix('sliders')->as('sliders.')->group(function () {
            Route::get('/', [SliderController::class, 'index'])->name('index')->can('viewAny', App\Models\Slider::class);
            Route::get('/create', [SliderController::class, 'create'])->name('create')->can('create', App\Models\Slider::class);
            Route::post('/', [SliderController::class, 'store'])->name('store')->can('create', App\Models\Slider::class);
            Route::get('/{slider}', [SliderController::class, 'show'])->name('show')->can('view', App\Models\Slider::class);
            Route::get('/get/{slider}', [SliderController::class, 'showDetail'])->name('detail')->can('view', 'slider');
            Route::patch('/publish/{slider}', [SliderController::class, 'publishSlider'])->name('publish')->can('publish', 'slider');
            Route::patch('/archive/{slider}', [SliderController::class, 'archiveSlider'])->name('archive')->can('archive', 'slider');
            Route::patch('/update/field/{slider}', [SliderController::class, 'updateField'])->name('updateField')->can('update', 'slider');
            Route::patch('/upload/file/{slider}', [SliderController::class, 'uploadFile'])->name('uploadFile')->can('update', 'slider');
            Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('destroy')->can('delete', 'slider');
        });
        
        Route::prefix('pages')->as('pages.')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('index')->can('viewAny', App\Models\Page::class);
            Route::get('/create', [PageController::class, 'create'])->name('create')->can('create', App\Models\Page::class);
            Route::post('/', [PageController::class, 'store'])->name('store')->can('create', App\Models\Page::class);
            Route::get('/{page}', [PageController::class, 'show'])->name('show')->can('view', 'page');
            Route::get('/get/{page}', [PageController::class, 'showDetail'])->name('detail')->can('view', 'page');
            Route::patch('/activate/{page}', [PageController::class, 'activatePage'])->name('activate')->can('activate', 'page');
            Route::patch('/update/field/{page}', [PageController::class, 'updateField'])->name('updateField')->can('update', 'page');
            Route::patch('/upload/file/{page}', [PageController::class, 'uploadFile'])->name('uploadFile')->can('update', 'page');
            Route::delete('/{page}', [PageController::class, 'destroy'])->name('destroy')->can('delete', 'page');
        });
        
        Route::prefix('stories')->as('stories.')->group(function () {
            Route::get('/', [StoryController::class, 'index'])->name('index')->can('viewAny', App\Models\Story::class);
            Route::get('/create', [StoryController::class, 'create'])->name('create')->can('create', App\Models\Story::class);
            Route::post('/', [StoryController::class, 'store'])->name('store')->can('create', App\Models\Story::class);
            Route::patch('/publish/{story}', [StoryController::class, 'publishStory'])->name('publish')->can('publish', App\Models\Story::class);
            Route::get('/{story}', [StoryController::class, 'show'])->name('show')->can('view', App\Models\Story::class);
            Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy')->can('delete', App\Models\Story::class);
        });
        
        Route::prefix('tenders')->as('tenders.')->group(function () {
            Route::get('/', [TenderController::class, 'index'])->name('index')->can('viewAny', App\Models\Tender::class);
            Route::get('/create', [TenderController::class, 'create'])->name('create')->can('create', App\Models\Tender::class);
            Route::post('/', [TenderController::class, 'store'])->name('store')->can('create', App\Models\Tender::class);
            Route::get('/{tender}', [TenderController::class, 'show'])->name('show')->can('view', App\Models\Tender::class);
            Route::get('/get/{tender}', [TenderController::class, 'showDetail'])->name('detail')->can('view', 'tender');
            Route::patch('/publish/{tender}', [TenderController::class, 'publishTender'])->name('publish')->can('publish', 'tender');
            Route::patch('/archive/{tender}', [TenderController::class, 'archiveTender'])->name('archive')->can('archive', 'tender');
            Route::patch('/update/field/{tender}', [TenderController::class, 'updateField'])->name('updateField')->can('update', 'tender');
            Route::delete('/{tender}', [TenderController::class, 'destroy'])->name('destroy')->can('delete', 'tender');
        });
        
        Route::prefix('schemes')->as('schemes.')->group(function () {
            Route::get('/', [SchemeController::class, 'index'])->name('index')->can('viewAny', App\Models\Scheme::class);
            Route::get('/sync', [SchemeController::class, 'syncSchemesView'])->name('syncView')->can('sync', App\Models\Scheme::class);
            Route::get('/get/{scheme}', [SchemeController::class, 'showDetail'])->name('detail')->can('view', App\Models\Scheme::class);
            Route::post('/sync', [SchemeController::class, 'syncSchemes'])->name('sync')->can('sync', App\Models\Scheme::class);
        });
        
        Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index')->can('viewAny', Spatie\Permission\Models\Role::class);
            Route::post('/', [RoleController::class, 'store'])->name('store')->can('create', Spatie\Permission\Models\Role::class);
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->can('delete', 'role');
            Route::get('/{role}/permissions', [RoleController::class, 'getPermissions'])->name('getPermissions')->can('update', Spatie\Permission\Models\Role::class);
            Route::patch('/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('updatePermissions')->can('update', Spatie\Permission\Models\Role::class);
        });
        
        Route::prefix('permissions')->as('permissions.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index')->can('viewAny', Spatie\Permission\Models\Permission::class);
            Route::post('/', [PermissionController::class, 'store'])->name('store')->can('create', Spatie\Permission\Models\Permission::class);
            Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy')->can('delete', 'permission');
        });
        
        Route::prefix('settings')->as('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index')->can('view', App\Models\Setting::class);
            Route::patch('/', [SettingController::class, 'update'])->name('update')->can('update', App\Models\Setting::class);
        });
        
        Route::prefix('categories')->as('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index')->can('viewAny', App\Models\Category::class);
            Route::post('/', [CategoryController::class, 'store'])->name('store')->can('create', App\Models\Category::class);
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy')->can('delete', 'category');
        });
        
        Route::prefix('districts')->as('districts.')->group(function () {
            Route::get('/', [DistrictController::class, 'index'])->name('index')->can('viewAny', App\Models\District::class);
            Route::post('/', [DistrictController::class, 'store'])->name('store')->can('create', App\Models\District::class);
            Route::delete('/{district}', [DistrictController::class, 'destroy'])->name('destroy')->can('delete', App\Models\District::class);
        });
        
        Route::prefix('comments')->as('comments.')->group(function () {
            Route::get('/', [CommentController::class, 'index'])->name('index')->can('viewAny', App\Models\Comment::class);
            Route::get('/{comment}', [CommentController::class, 'show'])->name('show')->can('view', App\Models\Comment::class);
            Route::get('/get/{comment}', [CommentController::class, 'showDetail'])->name('detail')->can('view', App\Models\Comment::class);
            Route::patch('/publish/{comment}', [CommentController::class, 'publishComment'])->name('publish')->can('publish', App\Models\Comment::class);
            Route::patch('/archive/{comment}', [CommentController::class, 'archiveComment'])->name('archive')->can('archive', App\Models\Comment::class);
            Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy')->can('delete', App\Models\Comment::class);
        });
        
        Route::get('/logs', ActivityLogController::class)->name('logs')->can('view', Spatie\Activitylog\Models\Activity::class);

    });
});