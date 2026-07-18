<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContactMessagePriority;
use App\Enums\ContactMessageStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * The filterable message inbox.
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'view', 'status', 'q', 'priority', 'service_id', 'assigned', 'from', 'to', 'sort',
        ]);

        $messages = ContactMessage::query()
            ->filter($filters, $request->user())
            ->with(['service', 'assignedTo'])
            ->withCount('replies')
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'filters' => $filters,
            'statusCounts' => $this->statusCounts($filters, $request),
            'services' => Service::query()->ordered()->get(['id', 'name']),
            'statuses' => ContactMessageStatus::cases(),
            'priorities' => ContactMessagePriority::cases(),
        ]);
    }

    /**
     * Full message view: conversation, tracking timeline, and actions.
     */
    public function show(Request $request, ContactMessage $message): View
    {
        $message->markAsRead($request->user());

        $message->load([
            'service',
            'assignedTo',
            'replies.user',
            'notes.user',
            'activities' => fn ($query) => $query->latest()->with('user'),
        ]);

        // Outbound replies and internal notes interleaved chronologically.
        $thread = $message->replies
            ->map(fn ($reply) => ['type' => 'reply', 'item' => $reply])
            ->concat($message->notes->map(fn ($note) => ['type' => 'note', 'item' => $note]))
            ->sortBy(fn (array $entry) => $entry['item']->created_at)
            ->values();

        return view('admin.messages.show', [
            'message' => $message,
            'thread' => $thread,
            'previousMessages' => ContactMessage::query()
                ->where('email', $message->email)
                ->whereKeyNot($message->id)
                ->latest()
                ->limit(5)
                ->get(),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
            'statuses' => ContactMessageStatus::cases(),
            'priorities' => ContactMessagePriority::cases(),
        ]);
    }

    /**
     * Permanently delete a message.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', "Message {$message->reference} was permanently deleted.");
    }

    /**
     * Per-status counts for the tab bar, ignoring the active status filter.
     *
     * @return array<string, int>
     */
    private function statusCounts(array $filters, Request $request): array
    {
        $counts = ContactMessage::query()
            ->filter([...$filters, 'status' => null, 'sort' => 'newest'], $request->user())
            ->groupBy('status')
            ->pluck(DB::raw('count(*) as total'), 'status')
            ->all();

        return ['all' => array_sum($counts), ...$counts];
    }
}
