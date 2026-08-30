<?php

use App\Http\Controllers\Admin\ArabicContentController;
use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ContactMessageArchiveController;
use App\Http\Controllers\Admin\ContactMessageAssignController;
use App\Http\Controllers\Admin\ContactMessageBulkController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContactMessageExportController;
use App\Http\Controllers\Admin\ContactMessagePriorityController;
use App\Http\Controllers\Admin\ContactMessageReplyController;
use App\Http\Controllers\Admin\ContactMessageStarController;
use App\Http\Controllers\Admin\ContactMessageStatusController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailTestController;
use App\Http\Controllers\Admin\PlanRequestController;
use App\Http\Controllers\Admin\PlanRequestStatusController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServicePlanController;
use App\Http\Controllers\Admin\ServicePlanStatusController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TechnologyController;
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
    Route::patch('messages/{message}/status', [ContactMessageStatusController::class, 'update'])->name('messages.status');
    Route::patch('messages/{message}/priority', [ContactMessagePriorityController::class, 'update'])->name('messages.priority');
    Route::patch('messages/{message}/star', [ContactMessageStarController::class, 'update'])->name('messages.star');
    Route::patch('messages/{message}/assign', [ContactMessageAssignController::class, 'update'])->name('messages.assign');
    Route::patch('messages/{message}/archive', [ContactMessageArchiveController::class, 'update'])->name('messages.archive');

    Route::get('plan-requests', [PlanRequestController::class, 'index'])->name('plan-requests.index');
    Route::get('plan-requests/{planRequest}', [PlanRequestController::class, 'show'])->name('plan-requests.show');
    Route::put('plan-requests/{planRequest}', [PlanRequestController::class, 'update'])->name('plan-requests.update');
    Route::delete('plan-requests/{planRequest}', [PlanRequestController::class, 'destroy'])->name('plan-requests.destroy');
    Route::patch('plan-requests/{planRequest}/status', [PlanRequestStatusController::class, 'update'])->name('plan-requests.status');

    Route::resource('services', ServiceController::class)->except(['show']);
    Route::patch('services/{service}/plans/{plan}/status', [ServicePlanStatusController::class, 'update'])
        ->scopeBindings()
        ->name('services.plans.status');
    Route::resource('services.plans', ServicePlanController::class)->except(['show'])->scoped();
    Route::resource('technologies', TechnologyController::class)->except(['show']);

    Route::get('arabic-content', [ArabicContentController::class, 'edit'])->name('arabic-content.edit');
    Route::put('arabic-content', [ArabicContentController::class, 'update'])->name('arabic-content.update');

    Route::get('settings/{section?}', [SettingsController::class, 'edit'])
        ->whereIn('section', SettingsController::SECTIONS)
        ->name('settings.edit');
    Route::put('settings/{section}', [SettingsController::class, 'update'])
        ->whereIn('section', SettingsController::SECTIONS)
        ->name('settings.update');
    Route::post('settings/email/test', EmailTestController::class)
        ->middleware('throttle:email-test')
        ->name('settings.email.test');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
