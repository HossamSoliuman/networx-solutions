<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactActivityType;
use App\Enums\ContactMessagePriority;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactMessagePriorityController extends Controller
{
    /**
     * Change the message priority.
     */
    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'priority' => ['required', Rule::enum(ContactMessagePriority::class)],
        ]);

        $priority = ContactMessagePriority::from($validated['priority']);

        if ($message->priority !== $priority) {
            $previous = $message->priority;
            $message->update(['priority' => $priority]);

            $message->recordActivity(ContactActivityType::PriorityChanged, $request->user(), [
                'from' => $previous->value,
                'to' => $priority->value,
            ]);
        }

        return back()->with('success', "Priority set to {$priority->label()}.");
    }
}
