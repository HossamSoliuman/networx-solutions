<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactActivityType;
use App\Enums\ContactMessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreReplyRequest;
use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactMessageReplyController extends Controller
{
    /**
     * Send an email reply to the message sender.
     */
    public function store(StoreReplyRequest $request, ContactMessage $message): RedirectResponse
    {
        $reply = $message->replies()->create([
            'user_id' => $request->user()->id,
            ...$request->validated(),
        ]);

        Mail::to($message->email, $message->name)->send(new ContactReplyMail($reply));

        if ($message->replied_at === null) {
            $message->update(['replied_at' => now()]);
        }

        $message->recordActivity(ContactActivityType::Replied, $request->user());
        $message->transitionTo(ContactMessageStatus::Replied, $request->user());

        return back()->with('success', "Reply sent to {$message->email}.");
    }
}
