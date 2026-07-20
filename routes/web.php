<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/contact', ContactController::class)->name('contact');

Route::post('/contact', [ContactFormController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.store');

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/llms.txt', [SeoController::class, 'llms'])->name('seo.llms');
