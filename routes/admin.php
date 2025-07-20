<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\SchemeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TenderController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\SeniorityController;
use App\Http\Controllers\Admin\TransferRequestController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\ProjectFileController;
use App\Http\Controllers\Admin\PublicContactController;
use App\Http\Controllers\Admin\DevelopmentProjectController;

Route::get('/portal', [HomeController::class, 'websiteAdmin'])->name('home');

Route::prefix('portal')->group(function () {
    Route::prefix('downloads')->as('downloads.')->group(function () {
        Route::get('/', [DownloadController::class, 'index'])->name('index')->can('viewAny', App\Models\Download::class);
        Route::get('/create', [DownloadController::class, 'create'])->name('create')->can('create', App\Models\Download::class);
        Route::post('/', [DownloadController::class, 'store'])->name('store')->can('create', App\Models\Download::class);
        Route::get('/{download}', [DownloadController::class, 'show'])->name('show')->can('view', 'download');
        Route::get('/get/{download}', [DownloadController::class, 'showDetail'])->name('detail')->can('view', 'download');
        Route::patch('/publish/{download}', [DownloadController::class, 'publishDownload'])->name('publish')->can('publish', 'download');
        Route::patch('/archive/{download}', [DownloadController::class, 'archiveDownload'])->name('archive')->can('archive', 'download');
        Route::patch('/update/field/{download}', [DownloadController::class, 'updateField'])->name('updateField')->can('updateField', 'download');
        Route::patch('/upload/file/{download}', [DownloadController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'download');
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
        Route::patch('/update/field/{event}', [EventController::class, 'updateField'])->name('updateField')->can('updateField', 'event');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy')->can('delete', 'event');
        Route::patch('/{event}/comments', [EventController::class, 'updateComments'])->name('comments')->can('comment', App\Models\Event::class);
    });

    Route::prefix('gallery')->as('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index')->can('viewAny', App\Models\Gallery::class);
        Route::get('/create', [GalleryController::class, 'create'])->name('create')->can('create', App\Models\Gallery::class);
        Route::post('/', [GalleryController::class, 'store'])->name('store')->can('create', App\Models\Gallery::class);
        Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show')->can('view', 'gallery');
        Route::get('/get/{gallery}', [GalleryController::class, 'showDetail'])->name('detail')->can('view', 'gallery');
        Route::patch('/publish/{gallery}', [GalleryController::class, 'publishGallery'])->name('publish')->can('publish', 'gallery');
        Route::patch('/archive/{gallery}', [GalleryController::class, 'archiveGallery'])->name('archive')->can('archive', 'gallery');
        Route::patch('/update/field/{gallery}', [GalleryController::class, 'updateField'])->name('updateField')->can('updateField', 'gallery');
        Route::patch('/upload/file/{gallery}', [GalleryController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'gallery');
        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy')->can('delete', 'gallery');
        Route::patch('/{gallery}/comments', [GalleryController::class, 'updateComments'])->name('comments')->can('comment', App\Models\Gallery::class);
    });

    Route::prefix('news')->as('news.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index')->can('viewAny', App\Models\News::class);
        Route::get('/create', [NewsController::class, 'create'])->name('create')->can('create', App\Models\News::class);
        Route::post('/', [NewsController::class, 'store'])->name('store')->can('create', App\Models\News::class);
        Route::get('/{news}', [NewsController::class, 'show'])->name('show')->can('view', 'news');
        Route::get('/get/{news}', [NewsController::class, 'showDetail'])->name('detail')->can('view', 'news');
        Route::patch('/publish/{news}', [NewsController::class, 'publishNews'])->name('publish')->can('publish', 'news');
        Route::patch('/archive/{news}', [NewsController::class, 'archiveNews'])->name('archive')->can('archive', 'news');
        Route::patch('/update/field/{news}', [NewsController::class, 'updateField'])->name('updateField')->can('updateField', 'news');
        Route::patch('/upload/file/{news}', [NewsController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'news');
        Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy')->can('delete', 'news');
        Route::patch('/{news}/comments', [NewsController::class, 'updateComments'])->name('comments')->can('comment', App\Models\News::class);
    });

    Route::prefix('seniority')->as('seniority.')->group(function () {
        Route::get('/', [SeniorityController::class, 'index'])->name('index')->can('viewAny', App\Models\Seniority::class);
        Route::get('/create', [SeniorityController::class, 'create'])->name('create')->can('create', App\Models\Seniority::class);
        Route::post('/', [SeniorityController::class, 'store'])->name('store')->can('create', App\Models\Seniority::class);
        Route::get('/{seniority}', [SeniorityController::class, 'show'])->name('show')->can('view', 'seniority');
        Route::get('/get/{seniority}', [SeniorityController::class, 'showDetail'])->name('detail')->can('view', 'seniority');
        Route::patch('/publish/{seniority}', [SeniorityController::class, 'publishSeniority'])->name('publish')->can('publish', 'seniority');
        Route::patch('/archive/{seniority}', [SeniorityController::class, 'archiveSeniority'])->name('archive')->can('archive', 'seniority');
        Route::patch('/update/field/{seniority}', [SeniorityController::class, 'updateField'])->name('updateField')->can('updateField', 'seniority');
        Route::patch('/upload/file/{seniority}', [SeniorityController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'seniority');
        Route::delete('/{seniority}', [SeniorityController::class, 'destroy'])->name('destroy')->can('delete', 'seniority');
        Route::patch('/{seniority}/comments', [SeniorityController::class, 'updateComments'])->name('comments')->can('comment', App\Models\Seniority::class);
    });

    Route::prefix('development_projects')->as('development_projects.')->group(function () {
        Route::get('/', [DevelopmentProjectController::class, 'index'])->name('index')->can('viewAny', App\Models\DevelopmentProject::class);
        Route::get('/create', [DevelopmentProjectController::class, 'create'])->name('create')->can('create', App\Models\DevelopmentProject::class);
        Route::post('/', [DevelopmentProjectController::class, 'store'])->name('store')->can('create', App\Models\DevelopmentProject::class);
        Route::get('/{development_project}', [DevelopmentProjectController::class, 'show'])->name('show')->can('view', 'development_project');
        Route::get('/get/{development_project}', [DevelopmentProjectController::class, 'showDetail'])->name('detail')->can('view', 'development_project');
        Route::patch('/publish/{development_project}', [DevelopmentProjectController::class, 'publishDevelopmentProject'])->name('publish')->can('publish', 'development_project');
        Route::patch('/archive/{development_project}', [DevelopmentProjectController::class, 'archiveDevelopmentProject'])->name('archive')->can('archive', 'development_project');
        Route::patch('/update/field/{development_project}', [DevelopmentProjectController::class, 'updateField'])->name('updateField')->can('updateField', 'development_project');
        Route::delete('/{development_project}', [DevelopmentProjectController::class, 'destroy'])->name('destroy')->can('delete', 'development_project');
        Route::patch('/{development_project}/comments', [DevelopmentProjectController::class, 'updateComments'])->name('comments')->can('comment', App\Models\DevelopmentProject::class);
    });

    Route::prefix('projects')->as('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index')->can('viewAny', App\Models\Project::class);
        Route::get('/create', [ProjectController::class, 'create'])->name('create')->can('create', App\Models\Project::class);
        Route::post('/', [ProjectController::class, 'store'])->name('store')->can('create', App\Models\Project::class);
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show')->can('view', 'project');
        Route::get('/get/{project}', [ProjectController::class, 'showDetail'])->name('detail')->can('view', 'project');
        Route::patch('/update/field/{project}', [ProjectController::class, 'updateField'])->name('updateField')->can('updateField', 'project');
        Route::patch('/upload/file/{project}', [ProjectController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'project');
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
        Route::patch('/update/field/{project_file}', [ProjectFileController::class, 'updateField'])->name('updateField')->can('updateField', 'project_file');
        Route::patch('/upload/file/{project_file}', [ProjectFileController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'project_file');
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
        Route::patch('/update/field/{slider}', [SliderController::class, 'updateField'])->name('updateField')->can('updateField', 'slider');
        Route::patch('/upload/file/{slider}', [SliderController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'slider');
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('destroy')->can('delete', 'slider');
        Route::patch('/{slider}/comments', [SliderController::class, 'updateComments'])->name('comments')->can('comment', App\Models\Slider::class);
    });

    Route::prefix('achievements')->as('achievements.')->group(function () {
        Route::get('/', [AchievementController::class, 'index'])->name('index')->can('viewAny', App\Models\Achievement::class);
        Route::get('/create', [AchievementController::class, 'create'])->name('create')->can('create', App\Models\Achievement::class);
        Route::post('/', [AchievementController::class, 'store'])->name('store')->can('create', App\Models\Achievement::class);
        Route::get('/{achievement}', [AchievementController::class, 'show'])->name('show')->can('view', App\Models\Achievement::class);
        Route::get('/get/{achievement}', [AchievementController::class, 'showDetail'])->name('detail')->can('view', 'achievement');
        Route::patch('/publish/{achievement}', [AchievementController::class, 'publishSlider'])->name('publish')->can('publish', 'achievement');
        Route::patch('/archive/{achievement}', [AchievementController::class, 'archiveSlider'])->name('archive')->can('archive', 'achievement');
        Route::patch('/update/field/{achievement}', [AchievementController::class, 'updateField'])->name('updateField')->can('updateField', 'achievement');
        Route::patch('/upload/file/{achievement}', [AchievementController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'achievement');
        Route::delete('/{achievement}', [AchievementController::class, 'destroy'])->name('destroy')->can('delete', 'achievement');
    });

    Route::prefix('pages')->as('pages.')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('index')->can('viewAny', App\Models\Page::class);
        Route::get('/create', [PageController::class, 'create'])->name('create')->can('create', App\Models\Page::class);
        Route::post('/', [PageController::class, 'store'])->name('store')->can('create', App\Models\Page::class);
        Route::get('/{page}', [PageController::class, 'show'])->name('show')->can('view', 'page');
        Route::get('/get/{page}', [PageController::class, 'showDetail'])->name('detail')->can('view', 'page');
        Route::patch('/activate/{page}', [PageController::class, 'activatePage'])->name('activate')->can('activate', 'page');
        Route::patch('/update/field/{page}', [PageController::class, 'updateField'])->name('updateField')->can('updateField', 'page');
        Route::patch('/upload/file/{page}', [PageController::class, 'uploadFile'])->name('uploadFile')->can('uploadFile', 'page');
        Route::delete('/{page}', [PageController::class, 'destroy'])->name('destroy')->can('delete', 'page');
    });

    Route::prefix('stories')->as('stories.')->group(function () {
        Route::get('/', [StoryController::class, 'index'])->name('index')->can('viewAny', App\Models\Story::class);
        Route::get('/create', [StoryController::class, 'create'])->name('create')->can('create', App\Models\Story::class);
        Route::post('/', [StoryController::class, 'store'])->name('store')->can('create', App\Models\Story::class);
        Route::patch('/publish/{story}', [StoryController::class, 'publishStory'])->name('publish')->can('publish', 'story');
        Route::get('/{story}', [StoryController::class, 'show'])->name('show')->can('view', 'story');
        Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy')->can('delete', 'story');
    });

    Route::prefix('tenders')->as('tenders.')->group(function () {
        Route::get('/', [TenderController::class, 'index'])->name('index')->can('viewAny', App\Models\Tender::class);
        Route::get('/create', [TenderController::class, 'create'])->name('create')->can('create', App\Models\Tender::class);
        Route::post('/', [TenderController::class, 'store'])->name('store')->can('create', App\Models\Tender::class);
        Route::get('/{tender}', [TenderController::class, 'show'])->name('show')->can('view', 'tender');
        Route::get('/get/{tender}', [TenderController::class, 'showDetail'])->name('detail')->can('view', 'tender');
        Route::patch('/publish/{tender}', [TenderController::class, 'publishTender'])->name('publish')->can('publish', 'tender');
        Route::patch('/archive/{tender}', [TenderController::class, 'archiveTender'])->name('archive')->can('archive', 'tender');
        Route::patch('/update/field/{tender}', [TenderController::class, 'updateField'])->name('updateField')->can('updateField', 'tender');
        Route::delete('/{tender}', [TenderController::class, 'destroy'])->name('destroy')->can('delete', 'tender');
        Route::patch('/{tender}/comments', [TenderController::class, 'updateComments'])->name('comments')->can('comment', App\Models\Tender::class);
    });

    Route::prefix('schemes')->as('schemes.')->group(function () {
        Route::get('/', [SchemeController::class, 'index'])->name('index')->can('viewAny', App\Models\Scheme::class);
        Route::get('/api', [SchemeController::class, 'schemes'])->name('api');
        Route::get('/sync', [SchemeController::class, 'syncSchemesView'])->name('syncView')->can('sync', App\Models\Scheme::class);
        Route::get('/get/{scheme}', [SchemeController::class, 'showDetail'])->name('detail')->can('view', 'scheme');
        Route::post('/sync', [SchemeController::class, 'syncSchemes'])->name('sync')->can('sync', App\Models\Scheme::class);
    });

    Route::prefix('comments')->as('comments.')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index')->can('viewAny', App\Models\Comment::class);
        Route::get('/{comment}', [CommentController::class, 'show'])->name('show')->can('view', 'comment');
        Route::get('/get/{comment}', [CommentController::class, 'showDetail'])->name('detail')->can('view', 'comment');
        Route::patch('/publish/{comment}', [CommentController::class, 'publishComment'])->name('publish')->can('publish', 'comment');
        Route::patch('/archive/{comment}', [CommentController::class, 'archiveComment'])->name('archive')->can('archive', 'comment');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy')->can('delete', 'comment');
        Route::get('/response/{comment}', [CommentController::class, 'getResponseView'])->name('getResponseView')->can('response', 'comment');
        Route::post('/response', [CommentController::class, 'postResponse'])->name('postResponse')->can('response', App\Models\Comment::class);
    });

    Route::prefix('newsletter')->as('newsletter.')->group(function () {
        Route::get('/', [NewsLetterController::class, 'index'])->name('index')->can('viewAny', App\Models\NewsLetter::class);
        Route::get('/mass-email', [NewsLetterController::class, 'createMassEmail'])->name('create_mass_email')->can('massEmail', App\Models\NewsLetter::class);
        Route::post('/mass-email', [NewsLetterController::class, 'sendMassEmail'])->name('send_mass_email')->can('massEmail', App\Models\NewsLetter::class);
    });

    Route::prefix('public_contact')->as('public_contact.')->group(function () {
        Route::get('/', [PublicContactController::class, 'index'])->name('index')->can('viewAny', App\Models\PublicContact::class);
        Route::get('/get/{PublicContact}', [PublicContactController::class, 'showDetail'])->name('detail')->can('view', 'PublicContact');
        Route::patch('/relief-grant/{PublicContact}', [PublicContactController::class, 'reliefGrant'])->name('grant')->can('reliefGrant', 'PublicContact');
        Route::patch('/relief-not-grant/{PublicContact}', [PublicContactController::class, 'reliefNotGrant'])->name('notgrant')->can('reliefNotGrant', 'PublicContact');
        Route::patch('/drop/{PublicContact}', [PublicContactController::class, 'drop'])->name('drop')->can('drop', 'PublicContact');
    });

    // Implement Roles here
    Route::prefix('transfer_requests')->as('transfer_requests.')->group(function () {
        Route::get('/', [TransferRequestController::class, 'index'])->name('index')->can('viewAny', App\Models\TransferRequest::class);
        Route::get('/create', [TransferRequestController::class, 'create'])->name('create')->can('create', App\Models\TransferRequest::class);
        Route::post('/', [TransferRequestController::class, 'store'])->name('store')->can('create', App\Models\TransferRequest::class);
        Route::delete('/{transfer_request}', [TransferRequestController::class, 'destroy'])->name('destroy')->can('delete', 'transfer_request');
        Route::patch('/review/{transfer_request}', [TransferRequestController::class, 'review'])->name('review')->can('review', 'transfer_request');
        Route::patch('/approve/{transfer_request}', [TransferRequestController::class, 'approve'])->name('approve')->can('approve', 'transfer_request');
        Route::patch('/reject/{transfer_request}', [TransferRequestController::class, 'reject'])->name('reject')->can('reject', 'transfer_request');
    });

});