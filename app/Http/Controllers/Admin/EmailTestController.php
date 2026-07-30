<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendTestEmailRequest;
use App\Mail\HostingerTestMail;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailTestController extends Controller
{
    /**
     * Send a synchronous message so the administrator gets immediate SMTP feedback.
     */
    public function __invoke(SendTestEmailRequest $request): RedirectResponse
    {
        $recipient = $request->string('mail_test_recipient')->value();

        Setting::set('mail_test_recipient', $recipient);

        if (! $this->mailConfigurationIsReady()) {
            return back()->with(
                'error',
                'Recipient saved, but Hostinger SMTP is not fully configured. Add the mailbox password to MAIL_PASSWORD and try again.',
            );
        }

        try {
            Mail::to($recipient)->send(new HostingerTestMail(
                requestedBy: $request->user()->name,
            ));
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'Recipient saved, but the test email could not be sent. Check the Hostinger mailbox password and SMTP settings.',
            );
        }

        return back()->with('success', "Test email sent to {$recipient}.");
    }

    private function mailConfigurationIsReady(): bool
    {
        return config('mail.default') === 'smtp'
            && filled(config('mail.mailers.smtp.host'))
            && filled(config('mail.mailers.smtp.username'))
            && filled(config('mail.mailers.smtp.password'))
            && filled(config('mail.from.address'));
    }
}
