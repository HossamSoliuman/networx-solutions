<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactMessageStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactMessageStatusController extends Controller
{
    /**
     * Move the message to a new status.
     */
    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(ContactMessageStatus::class)],
        ]);

        $status = ContactMessageStatus::from($validated['status']);

        $message->transitionTo($status, $request->user());

        return back()->with('success', "Status changed to {$status->label()}.");
    }
}
