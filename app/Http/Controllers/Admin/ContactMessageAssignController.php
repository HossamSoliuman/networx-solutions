<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactActivityType;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageAssignController extends Controller
{
    /**
     * Assign the message to a team member (or unassign).
     */
    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'assigned_to_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $assignee = isset($validated['assigned_to_id'])
            ? User::query()->find($validated['assigned_to_id'])
            : null;

        $message->update(['assigned_to_id' => $assignee?->id]);

        $message->recordActivity(ContactActivityType::Assigned, $request->user(), [
            'to' => $assignee?->name,
        ]);

        return back()->with('success', $assignee
            ? "Assigned to {$assignee->name}."
            : 'Message unassigned.');
    }
}
