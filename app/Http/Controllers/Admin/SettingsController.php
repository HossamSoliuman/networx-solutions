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
     * The website-content sections, each rendered as its own admin tab.
     *
     * @var list<string>
     */
    public const SECTIONS = ['pages', 'company', 'seo', 'messaging'];

    private const IMAGE_KEYS = ['home_image', 'about_image', 'contact_image'];

    /**
     * Show the settings form for one section.
     */
    public function edit(string $section = 'pages'): View
    {
        abort_unless(in_array($section, self::SECTIONS, true), 404);

        return view("admin.settings.{$section}", [
            'settings' => [
                ...Setting::siteValues(),
                'notification_email' => Setting::get('notification_email'),
                'mail_signature' => Setting::get('mail_signature'),
            ],
        ]);
    }

    /**
     * Persist the section's settings.
     */
    public function update(UpdateSettingsRequest $request, string $section): RedirectResponse
    {
        foreach ($request->safe()->except(self::IMAGE_KEYS) as $key => $value) {
            Setting::set($key, $value);
        }

        foreach (self::IMAGE_KEYS as $imageKey) {
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
