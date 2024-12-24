<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\UserController;
use App\Http\Controllers\Site\StoryController;
use App\Http\Controllers\Site\EventsController;
use App\Http\Controllers\Site\SearchController;
use App\Http\Controllers\Site\SliderController;
use App\Http\Controllers\Site\TenderController;
use App\Http\Controllers\Site\CommentController;
use App\Http\Controllers\Site\GalleryController;
use App\Http\Controllers\Site\ProjectController;
use App\Http\Controllers\Site\DownloadController;
use App\Http\Controllers\Site\SeniorityController;
use App\Http\Controllers\Site\NewsLetterController;
use App\Http\Controllers\Site\ServiceCardController;
use App\Http\Controllers\Site\PublicContactController;
use App\Http\Controllers\Site\EStandardizationController;
use App\Http\Controllers\Site\DevelopmentProjectController;
use App\Http\Controllers\Site\ContractorRegistrationController;
use App\Http\Controllers\Site\SchemeController;

Route::prefix('partials')->as('partials.')->group(function () {
    Route::get('/slider', [HomeController::class, 'sliderPartial'])->name('slider');
    Route::get('/message', [HomeController::class, 'messagePartial'])->name('message');
    Route::get('/about', [HomeController::class, 'aboutPartial'])->name('about');
    Route::get('/gallery', [HomeController::class, 'galleryPartial'])->name('gallery');
    Route::get('/blogs', [HomeController::class, 'blogsPartial'])->name('blogs');
    Route::get('/events', [HomeController::class, 'eventsPartial'])->name('events');
    Route::get('/team', [HomeController::class, 'teamPartial'])->name('team');
    Route::get('/contact', [HomeController::class, 'contactPartial'])->name('contact');
});

Route::prefix('registrations')->as('registrations.')->group(function () {
    Route::get('/apply', [ContractorRegistrationController::class, 'create'])->name('create');
    Route::post('/', [ContractorRegistrationController::class, 'store'])->name('store');
    Route::post('/check-pec', [ContractorRegistrationController::class, 'checkPEC'])->name('checkPEC');
    Route::get('/approved/{id}', [ContractorRegistrationController::class, 'approvedContractors'])->name('approved');
});

Route::prefix('standardizations')->as('standardizations.')->group(function () {
    Route::get('/apply', [EStandardizationController::class, 'create'])->name('create');
    Route::post('/', [EStandardizationController::class, 'store'])->name('store');
    Route::get('/approved/{id}', [EStandardizationController::class, 'approvedProducts'])->name('approved');
});

Route::prefix('stories')->as('stories.')->group(function () {
    Route::post('/', [StoryController::class, 'getStories'])->name('get');
    Route::patch('/viewed/{story}', [StoryController::class, 'incrementSeen'])->name('viewed');
});

Route::prefix('newsletter')->as('newsletter.')->group(function () {
    Route::post('/', [NewsLetterController::class, 'store'])->name('store');
    Route::get('/unsubscribe/{token}', [NewsLetterController::class, 'unsubscribe'])->name('unsubscribe');
});

Route::prefix('public_contact')->as('public_contact.')->group(function () {
    Route::post('/', [PublicContactController::class, 'store'])->name('store');
});

Route::prefix('sliders')->as('sliders.')->group(function () {
    Route::get('/{slug}', [SliderController::class, 'showSlider'])->name('showSlider');
});

Route::prefix('positions')->as('positions.')->group(function () {
    Route::get('/detail/{id}', [UserController::class, 'getUserDetails'])->name('details');
});

Route::prefix('contacts')->as('contacts.')->group(function () {
    Route::get('/', [UserController::class, 'contacts'])->name('index');
});

Route::prefix('service_cards')->as('service_cards.')->group(function () {
    Route::get('/apply', [ServiceCardController::class, 'create'])->name('create');
    Route::post('/', [ServiceCardController::class, 'store'])->name('store');
    Route::get('/verified/{id}', [ServiceCardController::class, 'verified'])->name('verified');
});

Route::prefix('news')->as('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/ticker', [NewsController::class, 'newsTicker'])->name('ticker');;
    Route::get('/{slug}', [NewsController::class, 'showNews'])->name('show');
});

Route::prefix('events')->as('events.')->group(function () {
    Route::get('/', [EventsController::class, 'index'])->name('index');
    Route::get('/{slug}', [EventsController::class, 'showEvent'])->name('show');
});

Route::prefix('tenders')->as('tenders.')->group(function () {
    Route::get('/', [TenderController::class, 'index'])->name('index');
    Route::get('/{slug}', [TenderController::class, 'show'])->name('show');
});

Route::prefix('seniority')->as('seniority.')->group(function () {
    Route::get('/', [SeniorityController::class, 'index'])->name('index');
    Route::get('/{slug}', [SeniorityController::class, 'showSeniority'])->name('show');
});

Route::prefix('development_projects')->as('development_projects.')->group(function () {
    Route::get('/', [DevelopmentProjectController::class, 'index'])->name('index');
    Route::get('/{slug}', [DevelopmentProjectController::class, 'showDevelopmentProject'])->name('show');
});

Route::prefix('gallery')->as('gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/{slug}', [GalleryController::class, 'showGalleryDetail'])->name('show');
});

Route::prefix('pages')->as('pages.')->group(function () {
    Route::get('/{type}', [PageController::class, 'showPage'])->name('show');
});

Route::prefix('downloads')->as('downloads.')->group(function () {
    Route::get('/', [DownloadController::class, 'index'])->name('index');
    Route::post('/fetch-category', [DownloadController::class, 'fetchCategory'])->name('fetch-category');
});

Route::prefix('projects')->as('projects.')->group(function () {
    Route::get('/{name}', [ProjectController::class, 'showProject'])->name('show');
});

Route::get('/team', [UserController::class, 'team'])->name('team');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::prefix('notifications')->as('notifications.')->group(function () {
    Route::get('/all', [HomeController::class, 'allNotifications'])->name('index');
    Route::get('/', [HomeController::class, 'notifications'])->name('get');
});

Route::prefix('comments')->as('comments.')->group(function () {
    Route::post('/{type}/{id}', [CommentController::class, 'store'])->name('store');
});

Route::prefix('schemes')->as('schemes.')->group(function () {
    Route::get('/', [SchemeController::class, 'index'])->name('index');
    Route::get('/{scheme}', [SchemeController::class, 'show'])->name('show');
});