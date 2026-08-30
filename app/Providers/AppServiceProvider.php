<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\PlanRequest;
use App\Models\Service;
use App\Models\Setting;
use App\Support\MailSettings;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->resolving('mail.manager', function (): void {
            MailSettings::applyToConfig();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());

        RateLimiter::for('contact-form', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('plan-request', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->string('email')->lower()->value().'|'.$request->ip());
        });

        RateLimiter::for('email-test', function (Request $request) {
            return Limit::perMinute(3)->by($request->user()->getAuthIdentifier().'|'.$request->ip());
        });

        View::composer('layouts.admin', function (\Illuminate\View\View $view): void {
            $view
                ->with('unreadCount', ContactMessage::query()->inbox()->unread()->count())
                ->with('unreadPlanRequestCount', PlanRequest::query()->unread()->count());
        });

        View::composer([
            'home',
            'about',
            'services.index',
            'services.show',
            'contact',
        ], function (\Illuminate\View\View $view): void {
            $view
                ->with('site', Setting::localizedSiteValues())
                ->with('navigationServices', Service::query()->active()->ordered()->get(['id', 'name', 'name_ar', 'slug']));
        });
    }
}
