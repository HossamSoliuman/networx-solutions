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
            'mailConfiguration' => $this->mailConfiguration(),
        ]);
    }

    /**
     * Persist the section's settings.
     */
    public function update(UpdateSettingsRequest $request, string $section): RedirectResponse
    {
        foreach ($request->validated() as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }

    /**
     * @return array{mailer: string, host: string, port: int, scheme: string, username: ?string, from_address: string, password_configured: bool, ready: bool}
     */
    private function mailConfiguration(): array
    {
        $mailer = (string) config('mail.default');
        $host = (string) config('mail.mailers.smtp.host');
        $port = (int) config('mail.mailers.smtp.port');
        $scheme = (string) config('mail.mailers.smtp.scheme');
        $username = config('mail.mailers.smtp.username');
        $fromAddress = (string) config('mail.from.address');
        $passwordConfigured = filled(config('mail.mailers.smtp.password'));

        return [
            'mailer' => $mailer,
            'host' => $host,
            'port' => $port,
            'scheme' => $scheme,
            'username' => is_string($username) ? $username : null,
            'from_address' => $fromAddress,
            'password_configured' => $passwordConfigured,
            'ready' => $mailer === 'smtp'
                && filled($host)
                && filled($username)
                && $passwordConfigured
                && filled($fromAddress),
        ];
    }
}
