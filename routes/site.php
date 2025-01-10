<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ContractorAuth;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\UserController;
use App\Http\Controllers\Site\StoryController;
use App\Http\Controllers\Site\EventsController;
use App\Http\Controllers\Site\SchemeController;
use App\Http\Controllers\Site\SearchController;
use App\Http\Controllers\Site\SliderController;
use App\Http\Controllers\Site\TenderController;
use App\Http\Controllers\Site\CommentController;
use App\Http\Controllers\Site\GalleryController;
use App\Http\Controllers\Site\ProjectController;
use App\Http\Controllers\Site\DownloadController;
use App\Http\Controllers\Site\SeniorityController;
use App\Http\Controllers\Site\ContractorController;
use App\Http\Controllers\Site\NewsLetterController;
use App\Http\Controllers\Site\ServiceCardController;
use App\Http\Controllers\Site\PublicContactController;
use App\Http\Controllers\Site\StandardizationController;
use App\Http\Middleware\ContractorRedirectIfAuthenticated;
use App\Http\Controllers\Site\DevelopmentProjectController;

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

Route::prefix('contractors')->as('contractors.')->group(function () {
    Route::get('/', [ContractorController::class, 'registration'])->name('registration');
    Route::post('/', [ContractorController::class, 'store'])->name('store');
    Route::post('/check-pec', [ContractorController::class, 'checkPEC'])->name('checkPEC');
    Route::get('/approved/{id}', [ContractorController::class, 'approvedContractors'])->name('approved');

    Route::middleware([ContractorRedirectIfAuthenticated::class])->group(function () {
        Route::get('/login', [ContractorController::class, 'login_view'])->name('login');
        Route::post('/login', [ContractorController::class, 'login'])->name('login');
        Route::get('/register', [ContractorController::class, 'register'])->name('register');
    });

    Route::middleware(ContractorAuth::class)->group(function () {
        Route::get('/dashboard', [ContractorController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [ContractorController::class, 'logout'])->name('logout');
        
        Route::get('/password', [ContractorController::class, 'PasswordView'])->name('password.view');
        Route::post('/password', [ContractorController::class, 'updatePassword'])->name('password.update');
        
        Route::get('/edit', [ContractorController::class, 'edit'])->name('edit');
        Route::patch('/update', [ContractorController::class, 'update'])->name('update');

        Route::get('/hr-profiles', [ContractorController::class, 'createHrProfiles'])->name('hr_profiles.create');
        Route::post('/hr-profiles', [ContractorController::class, 'storeHrProfile'])->name('hr_profiles.store');

        Route::get('/machinery', [ContractorController::class, 'createMachinery'])->name('machinery.create');
        Route::post('/machinery', [ContractorController::class, 'storeMachinery'])->name('machinery.store');

        Route::get('/work-experience', [ContractorController::class, 'createWorkExperience'])->name('work_experience.create');
        Route::post('/work-experience', [ContractorController::class, 'storeWorkExperience'])->name('work_experience.store');
    });
});

Route::prefix('standardizations')->as('standardizations.')->group(function () {
    Route::get('/apply', [StandardizationController::class, 'create'])->name('create');
    Route::post('/', [StandardizationController::class, 'store'])->name('store');
    Route::get('/approved/{id}', [StandardizationController::class, 'approvedProducts'])->name('approved');
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
    Route::get('/detail/{uuid}', [UserController::class, 'getUserDetails'])->name('details');
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