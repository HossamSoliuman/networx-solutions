<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactMessageStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageBulkController extends Controller
{
    /**
     * Apply an action to a selection of messages.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:mark_read,mark_unread,archive,restore,close,delete'],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:contact_messages,id'],
        ]);

        $query = ContactMessage::query()->whereKey($validated['ids']);
        $count = count($validated['ids']);

        match ($validated['action']) {
            'mark_read' => $query->whereNull('read_at')->update(['read_at' => now()]),
            'mark_unread' => $query->update(['read_at' => null]),
            'archive' => $query->update(['archived_at' => now()]),
            'restore' => $query->update(['archived_at' => null]),
            'close' => $query->update(['status' => ContactMessageStatus::Closed, 'closed_at' => now()]),
            'delete' => $query->delete(),
        };

        $label = match ($validated['action']) {
            'mark_read' => 'marked as read',
            'mark_unread' => 'marked as unread',
            'archive' => 'archived',
            'restore' => 'restored',
            'close' => 'closed',
            'delete' => 'deleted',
        };

        return back()->with('success', "{$count} ".str('message')->plural($count)." {$label}.");
    }
}
