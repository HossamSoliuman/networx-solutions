<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Models\Setting;
use App\Support\MailSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * The website-content sections, each rendered as its own admin tab.
     *
     * @var list<string>
     */
    public const SECTIONS = ['company', 'seo', 'messaging', 'email'];

    /**
     * Show the settings form for one section.
     */
    public function edit(string $section = 'company'): View
    {
        abort_unless(in_array($section, self::SECTIONS, true), 404);

        return view("admin.settings.{$section}", [
            'settings' => [
                ...Setting::siteValues(),
                'notification_email' => Setting::get('notification_email'),
                'mail_signature' => Setting::get('mail_signature'),
                'mail_test_recipient' => Setting::get('mail_test_recipient', auth()->user()?->email),
            ],
            'mailConfiguration' => MailSettings::configuration(),
        ]);
    }

    /**
     * Persist the section's settings.
     */
    public function update(UpdateSettingsRequest $request, string $section): RedirectResponse
    {
        $validated = $request->validated();

        if ($section === 'email') {
            $this->saveMailPassword($request);

            unset($validated['mail_password'], $validated['remove_mail_password']);
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }

    /**
     * A blank field keeps the saved password; the removal toggle falls back to the environment value.
     */
    private function saveMailPassword(UpdateSettingsRequest $request): void
    {
        if ($request->boolean('remove_mail_password')) {
            MailSettings::forgetPassword();

            return;
        }

        $password = (string) $request->input('mail_password');

        if ($password !== '') {
            MailSettings::storePassword($password);
        }
    }
}
