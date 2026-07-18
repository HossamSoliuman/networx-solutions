<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show the site settings form.
     */
    public function edit(): View
    {
        $keys = [
            'site_name', 'tagline', 'contact_email', 'contact_phone', 'address', 'website',
            'facebook_url', 'linkedin_url', 'instagram_url', 'notification_email', 'mail_signature',
        ];

        return view('admin.settings.edit', [
            'settings' => collect($keys)->mapWithKeys(
                fn (string $key) => [$key => Setting::get($key)]
            ),
        ]);
    }

    /**
     * Persist the settings.
     */
    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        foreach ($request->validated() as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }
}
