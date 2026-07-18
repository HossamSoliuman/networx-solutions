<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show the site settings form.
     */
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => [
                ...Setting::siteValues(),
                'notification_email' => Setting::get('notification_email'),
                'mail_signature' => Setting::get('mail_signature'),
            ],
        ]);
    }

    /**
     * Persist the settings.
     */
    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        foreach ($request->safe()->except(['home_image', 'about_image', 'contact_image']) as $key => $value) {
            Setting::set($key, $value);
        }

        foreach (['home_image', 'about_image', 'contact_image'] as $imageKey) {
            if (! $request->hasFile($imageKey)) {
                continue;
            }

            $oldPath = Setting::get($imageKey);
            Setting::set($imageKey, $request->file($imageKey)->store('site', 'public'));

            if ($oldPath && ! Str::startsWith($oldPath, 'images/')) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        return back()->with('success', 'Settings saved.');
    }
}
