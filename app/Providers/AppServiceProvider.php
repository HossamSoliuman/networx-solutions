<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Setting;
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
        //
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

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->string('email')->lower()->value().'|'.$request->ip());
        });

        View::composer('layouts.admin', function (\Illuminate\View\View $view): void {
            $view->with('unreadCount', ContactMessage::query()->inbox()->unread()->count());
        });

        View::composer([
            'home',
            'about',
            'services.index',
            'services.show',
            'contact',
        ], function (\Illuminate\View\View $view): void {
            $view
                ->with('site', Setting::siteValues())
                ->with('navigationServices', Service::query()->active()->ordered()->get(['id', 'name', 'slug']));
        });
    }
}
