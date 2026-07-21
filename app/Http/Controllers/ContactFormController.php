<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\NewContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactFormController extends Controller
{
    /**
     * Store a message submitted through the public contact form.
     */
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $phoneLocal = Str::squish($validated['phone_local']);
        $phone = str_starts_with($phoneLocal, '+')
            ? $phoneLocal
            : $validated['phone_country'].' '.$phoneLocal;

        $message = ContactMessage::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $phone,
            'company' => $validated['company'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'service_id' => $validated['service_id'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => (string) str($request->userAgent() ?? '')->limit(255, ''),
        ]);

        if ($notificationEmail = Setting::get('notification_email')) {
            Mail::to($notificationEmail)->send(new NewContactMessageMail($message));
        }

        return back()->with('contact_success', "Thank you! Your message has been received. Your reference is {$message->reference}.");
    }
}
