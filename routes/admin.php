<?php

use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ContactMessageArchiveController;
use App\Http\Controllers\Admin\ContactMessageAssignController;
use App\Http\Controllers\Admin\ContactMessageBulkController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContactMessageExportController;
use App\Http\Controllers\Admin\ContactMessageNoteController;
use App\Http\Controllers\Admin\ContactMessagePriorityController;
use App\Http\Controllers\Admin\ContactMessageReplyController;
use App\Http\Controllers\Admin\ContactMessageStarController;
use App\Http\Controllers\Admin\ContactMessageStatusController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('messages/export', ContactMessageExportController::class)->name('messages.export');
    Route::post('messages/bulk', [ContactMessageBulkController::class, 'store'])->name('messages.bulk');
    Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
    Route::post('messages/{message}/reply', [ContactMessageReplyController::class, 'store'])->name('messages.reply');
    Route::post('messages/{message}/notes', [ContactMessageNoteController::class, 'store'])->name('messages.notes.store');
    Route::patch('messages/{message}/status', [ContactMessageStatusController::class, 'update'])->name('messages.status');
    Route::patch('messages/{message}/priority', [ContactMessagePriorityController::class, 'update'])->name('messages.priority');
    Route::patch('messages/{message}/star', [ContactMessageStarController::class, 'update'])->name('messages.star');
    Route::patch('messages/{message}/assign', [ContactMessageAssignController::class, 'update'])->name('messages.assign');
    Route::patch('messages/{message}/archive', [ContactMessageArchiveController::class, 'update'])->name('messages.archive');

    Route::resource('services', ServiceController::class)->except(['show']);

    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
