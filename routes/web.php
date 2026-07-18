<?php

use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('/contact', [ContactFormController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.store');
