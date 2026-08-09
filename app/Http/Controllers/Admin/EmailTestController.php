<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendTestEmailRequest;
use App\Mail\HostingerTestMail;
use App\Models\Setting;
use App\Support\MailSettings;
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

        if (! MailSettings::isReady()) {
            return back()->with(
                'error',
                'Recipient saved, but Hostinger SMTP is not fully configured. Save the mailbox password below and try again.',
            );
        }

        MailSettings::applyToConfig();

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
}
