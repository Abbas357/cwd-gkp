<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ConsultantAuth;
use App\Http\Middleware\ContractorAuth;
use App\Http\Middleware\StandardizationAuth;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\UserController;
use App\Http\Controllers\Site\LearnController;
use App\Http\Controllers\Site\StoryController;
use App\Http\Controllers\Site\DamageController;
use App\Http\Controllers\Site\EventsController;
use App\Http\Controllers\Site\SchemeController;
use App\Http\Controllers\Site\SearchController;
use App\Http\Controllers\Site\SliderController;
use App\Http\Controllers\Site\TenderController;
use App\Http\Controllers\Site\CommentController;
use App\Http\Controllers\Site\GalleryController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\ProjectController;
use App\Http\Controllers\Site\DownloadController;
use App\Http\Controllers\Site\SeniorityController;
use App\Http\Controllers\Site\ConsultantController;
use App\Http\Controllers\Site\ContractorController;
use App\Http\Controllers\Site\NewsLetterController;
use App\Http\Controllers\Site\AchievementController;
use App\Http\Controllers\Site\ServiceCardController;
use App\Http\Controllers\Site\PublicContactController;
use App\Http\Controllers\Site\StandardizationController;
use App\Http\Controllers\Site\ConsultantProjectController;
use App\Http\Middleware\ConsultantRedirectIfAuthenticated;
use App\Http\Middleware\ContractorRedirectIfAuthenticated;
use App\Http\Controllers\Site\DevelopmentProjectController;
use App\Http\Controllers\Site\ContractorMachineryController;
use App\Http\Controllers\Site\ContractorRegistrationController;
use App\Http\Middleware\StandardizationRedirectIfAuthenticated;
use App\Http\Controllers\Site\ConsultantHumanResourceController;
use App\Http\Controllers\Site\ContractorHumanResourceController;
use App\Http\Controllers\SecureDocument\SecureDocumentController;
use App\Http\Controllers\Site\ContractorWorkExperienceController; 
 
Route::prefix('partials')->as('partials.')->group(function () {
    Route::get('/slider', [HomeController::class, 'sliderPartial'])->name('slider');
    Route::get('/message', [HomeController::class, 'messagePartial'])->name('message');
    Route::get('/about', [HomeController::class, 'aboutPartial'])->name('about');
    Route::get('/gallery', [HomeController::class, 'galleryPartial'])->name('gallery');
    Route::get('/blogs', [HomeController::class, 'newsPartial'])->name('blogs');
    Route::get('/events', [HomeController::class, 'eventsPartial'])->name('events');
    Route::get('/team', [HomeController::class, 'teamPartial'])->name('team');
    Route::get('/contact', [HomeController::class, 'contactPartial'])->name('contact');
});

Route::prefix('contractors')->as('contractors.')->middleware('route_lock')->group(function () {
    Route::post('/', [ContractorController::class, 'store'])->name('store');
    Route::post('/check', [ContractorController::class, 'checkFields'])->name('check');
    Route::get('/approved/{uuid}', [ContractorRegistrationController::class, 'approvedContractors'])->name('approved');

    Route::middleware([ContractorRedirectIfAuthenticated::class])->group(function () {
        Route::get('/login', [ContractorController::class, 'view_login'])->name('login.get');
        Route::post('/login', [ContractorController::class, 'login'])->name('login.post');
        Route::get('/register', [ContractorController::class, 'register'])->name('register');
    });

    Route::middleware(ContractorAuth::class)->group(function () {

        Route::get('/dashboard', [ContractorController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [ContractorController::class, 'logout'])->name('logout');

        Route::get('/password', [ContractorController::class, 'PasswordView'])->name('password.view');
        Route::post('/password', [ContractorController::class, 'updatePassword'])->name('password.update');

        Route::get('/edit', [ContractorController::class, 'edit'])->name('edit');
        Route::patch('/update', [ContractorController::class, 'update'])->name('update');

        Route::prefix('registration')->as('registration.')->group(function () {
            Route::get('/view', [ContractorRegistrationController::class, 'index'])->name('index');
            Route::get('/{uuid}/edit', [ContractorRegistrationController::class, 'edit'])->name('edit');
            Route::patch('/{uuid}', [ContractorRegistrationController::class, 'update'])->name('update');
            Route::get('/apply', [ContractorRegistrationController::class, 'create'])->name('create');
            Route::post('/', [ContractorRegistrationController::class, 'store'])->name('store');
            Route::post('/check-pec', [ContractorRegistrationController::class, 'checkPEC'])->name('checkPEC');
            Route::get('/{uuid}', [ContractorRegistrationController::class, 'show'])->name('show');
        });

        Route::prefix('machinery')->as('machinery.')->group(function () {
            Route::get('/', [ContractorMachineryController::class, 'create'])->name('create');
            Route::post('/', [ContractorMachineryController::class, 'store'])->name('store');
        });

        Route::prefix('hr')->as('hr.')->group(function () {
            Route::get('/', [ContractorHumanResourceController::class, 'create'])->name('create');
            Route::post('/', [ContractorHumanResourceController::class, 'store'])->name('store');
        });

        Route::prefix('experience')->as('experience.')->group(function () {
            Route::get('/', [ContractorWorkExperienceController::class, 'create'])->name('create');
            Route::post('/', [ContractorWorkExperienceController::class, 'store'])->name('store');
        });
    });
});

Route::prefix('standardizations')->as('standardizations.')->middleware('route_lock')->group(function () {
    Route::post('/', [StandardizationController::class, 'store'])->name('store');
    Route::post('/check', [StandardizationController::class, 'checkFields'])->name('check');
    Route::get('/approved/{uuid}', [StandardizationController::class, 'approvedProducts'])->name('approved');

    Route::middleware([StandardizationRedirectIfAuthenticated::class])->group(function () {
        Route::get('/login', [StandardizationController::class, 'view_login'])->name('login.get');
        Route::post('/login', [StandardizationController::class, 'login'])->name('login.post');
        Route::get('/register', [StandardizationController::class, 'register'])->name('register');
    });

    Route::middleware(StandardizationAuth::class)->group(function () {
        Route::get('/dashboard', [StandardizationController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [StandardizationController::class, 'logout'])->name('logout');

        Route::get('/password', [StandardizationController::class, 'PasswordView'])->name('password.view');
        Route::post('/password', [StandardizationController::class, 'updatePassword'])->name('password.update');
        
        Route::get('/upload', [StandardizationController::class, 'uploadDocsView'])->name('upload.get');
        Route::patch('/upload', [StandardizationController::class, 'uploadDocs'])->name('upload');

        Route::get('/edit', [StandardizationController::class, 'edit'])->name('edit');
        Route::patch('/update', [StandardizationController::class, 'update'])->name('update');
        
        Route::prefix('product')->as('product.')->middleware(['standardization.documents.uploaded'])->group(function () {
            Route::get('/view', [ProductController::class, 'index'])->name('index');
            Route::get('/', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        });
    });

});

Route::prefix('consultants')->as('consultants.')->middleware('route_lock')->group(function () {
    Route::get('/', [ConsultantController::class, 'view'])->name('view');
    Route::get('/detail/{uuid}', [ConsultantController::class, 'show'])->name('show');
    Route::post('/store', [ConsultantController::class, 'store'])->name('store');
    Route::post('/check', [ConsultantController::class, 'checkFields'])->name('check');

    Route::middleware([ConsultantRedirectIfAuthenticated::class])->group(function () {
        Route::get('/login', [ConsultantController::class, 'view_login'])->name('login.get');
        Route::post('/login', [ConsultantController::class, 'login'])->name('login.post');
        Route::get('/register', [ConsultantController::class, 'register'])->name('register');
    });

    Route::middleware(ConsultantAuth::class)->group(function () {

        Route::get('/dashboard', [ConsultantController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [ConsultantController::class, 'logout'])->name('logout');

        Route::get('/password', [ConsultantController::class, 'PasswordView'])->name('password.view');
        Route::post('/password', [ConsultantController::class, 'updatePassword'])->name('password.update');

        Route::get('/edit', [ConsultantController::class, 'edit'])->name('edit');
        Route::patch('/update', [ConsultantController::class, 'update'])->name('update');

        Route::prefix('projects')->as('projects.')->group(function () {
            Route::get('/', [ConsultantProjectController::class, 'create'])->name('create');
            Route::post('/', [ConsultantProjectController::class, 'store'])->name('store');
        });

        Route::prefix('hr')->as('hr.')->group(function () {
            Route::get('/', [ConsultantHumanResourceController::class, 'create'])->name('create');
            Route::post('/', [ConsultantHumanResourceController::class, 'store'])->name('store');
        });

    });
});

Route::prefix('service_cards')->as('service_cards.')->middleware('route_lock')->group(function () {
    Route::get('/apply', [ServiceCardController::class, 'create'])->name('create');
    Route::post('/', [ServiceCardController::class, 'store'])->name('store');
    Route::get('/verified/{uuid}', [ServiceCardController::class, 'verified'])->name('verified');
});

Route::prefix('documents')->as('documents.')->middleware('route_lock')->group(function () {
    Route::get('/approved/{uuid}', [SecureDocumentController::class, 'approved'])->name('approved');
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

Route::prefix('achievements')->as('achievements.')->group(function () {
    Route::get('/', [AchievementController::class, 'index'])->name('index');
    Route::get('/{slug}', [AchievementController::class, 'showAchievement'])->name('show');
});

Route::prefix('development_projects')->as('development_projects.')->group(function () {
    Route::get('/', [DevelopmentProjectController::class, 'index'])->name('index');
    Route::get('/{slug}', [DevelopmentProjectController::class, 'showDevelopmentProject'])->name('show');
});

Route::prefix('gallery')->as('gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/{slug}', [GalleryController::class, 'showGalleryDetail'])->name('show');
    Route::get('/type/{type}', [GalleryController::class, 'getGalleriesByType'])->name('type');
});

Route::prefix('news')->as('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/ticker', [NewsController::class, 'newsTicker'])->name('ticker');;
    Route::get('/{slug}', [NewsController::class, 'showNews'])->name('show');
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

Route::prefix('announcement')->as('announcement.')->group(function () {
    Route::get('/', [HomeController::class, 'announcement'])->name('get');
});

Route::prefix('comments')->as('comments.')->group(function () {
    Route::post('/{type}/{id}', [CommentController::class, 'store'])->name('store');
});

Route::prefix('schemes')->as('schemes.')->group(function () {
    Route::get('/', [SchemeController::class, 'index'])->name('index');
    Route::get('/{scheme}', [SchemeController::class, 'show'])->name('show');
});

Route::prefix('learn')->as('learn.')->group(function () {
    Route::get('/epads', [LearnController::class, 'epads'])->name('epads');
    Route::get('/kpdws', [LearnController::class, 'kpdws'])->name('kpdws');
});

$activity = setting('activity', 'dmis');
Route::prefix($activity)->as($activity.'.')->group(function () {
    $session = setting('session', 'dmis');
    Route::get("/{$session}", [DamageController::class, 'index'])->name('index');
    Route::get("/{$session}/{district}", [DamageController::class, 'districtDetail'])->name('detail.district');
});
