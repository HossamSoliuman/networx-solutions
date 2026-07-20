<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactMessageStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Builder;
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
            'mark_read' => $this->markRead($query),
            'mark_unread' => $this->markUnread($query),
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

    /**
     * Stamp read_at and move still-New messages forward to Read.
     *
     * @param  Builder<ContactMessage>  $query
     */
    private function markRead(Builder $query): void
    {
        $query->clone()->whereNull('read_at')->update(['read_at' => now()]);
        $query->clone()->where('status', ContactMessageStatus::New)->update(['status' => ContactMessageStatus::Read]);
    }

    /**
     * Clear read_at and move Read messages back to New, leaving richer
     * statuses (In Progress, Replied, Closed) untouched.
     *
     * @param  Builder<ContactMessage>  $query
     */
    private function markUnread(Builder $query): void
    {
        $query->clone()->update(['read_at' => null]);
        $query->clone()->where('status', ContactMessageStatus::Read)->update(['status' => ContactMessageStatus::New]);
    }
}
