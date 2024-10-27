<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\EStandardizationController;
use App\Http\Controllers\ContractorRegistrationController;

Route::prefix('partials')->as('partials.')->group(function () {
    Route::get('/message', [HomePageController::class, 'messagePartial'])->name('message');
    Route::get('/about', [HomePageController::class, 'aboutPartial'])->name('about');
    Route::get('/gallery', [HomePageController::class, 'galleryPartial'])->name('gallery');
    Route::get('/blogs', [HomePageController::class, 'blogsPartial'])->name('blogs');
    Route::get('/team', [HomePageController::class, 'teamPartial'])->name('team');
    Route::get('/contact', [HomePageController::class, 'contactPartial'])->name('contact');
});

Route::prefix('registrations')->as('registrations.')->group(function () {
    Route::get('/create', [ContractorRegistrationController::class, 'create'])->name('create');
    Route::post('/', [ContractorRegistrationController::class, 'store'])->name('store');
    Route::post('/check-pec', [ContractorRegistrationController::class, 'checkPEC'])->name('checkPEC');
    Route::get('/approved/{id}', [ContractorRegistrationController::class, 'approvedContractors'])->name('approved');
});

Route::prefix('standardizations')->as('standardizations.')->group(function () {
    Route::get('/create', [EStandardizationController::class, 'create'])->name('create');
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
    Route::get('/{slug}', [HomePageController::class, 'showSlider'])->name('showSlider');
});

Route::prefix('positions')->as('positions.')->group(function () {
    Route::get('/{designation}', [HomePageController::class, 'showPositions'])->name('show');
    Route::get('/details/{id}', [HomePageController::class, 'getUserDetails'])->name('details');
});

Route::prefix('news')->as('news.')->group(function () {
    Route::get('/{slug}', [HomePageController::class, 'showNews'])->name('show');
});

Route::prefix('gallery')->as('gallery.')->group(function () {
    Route::get('/{slug}', [HomePageController::class, 'showGalleryDetail'])->name('show');
});