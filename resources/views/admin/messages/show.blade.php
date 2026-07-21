@extends('layouts.admin')

@section('title', $message->reference)

@section('content')
    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <x-button :href="route('admin.messages.index')" variant="ghost" icon="arrow-left">Inbox</x-button>
            <div>
                <h1 class="flex items-center gap-2.5 font-display text-xl font-bold tracking-tight text-navy-900">
                    {{ $message->subject }}
                    <x-status-badge :status="$message->status" />
                </h1>
                <p class="mt-0.5 text-xs text-slate-400">
                    {{ $message->reference }} · received {{ $message->created_at->format('M j, Y \a\t g:i A') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <form method="POST" action="{{ route('admin.messages.star', $message) }}">
                @csrf @method('PATCH')
                <x-button type="submit" variant="secondary"
                    class="{{ $message->is_starred ? 'text-amber-500' : '' }}">
                    <x-icon name="star" :solid="$message->is_starred" class="size-4" />
                    {{ $message->is_starred ? 'Starred' : 'Star' }}
                </x-button>
            </form>

            <form method="POST" action="{{ route('admin.messages.archive', $message) }}">
                @csrf @method('PATCH')
                <x-button type="submit" variant="secondary" icon="archive">
                    {{ $message->isArchived() ? 'Restore' : 'Archive' }}
                </x-button>
            </form>

            <x-button variant="danger-soft" icon="trash" data-modal-open="delete-message">Delete</x-button>
        </div>
    </div>

    @if ($message->isArchived())
        <div class="flex items-center gap-2 rounded-lg bg-amber-50 px-4 py-2.5 text-sm text-amber-800 ring-1 ring-inset ring-amber-200">
            <x-icon name="archive" class="size-4" />
            This message is archived. It stays out of the inbox but keeps its full history.
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- Main column --}}
        <div class="space-y-6 xl:col-span-2">
            {{-- Original message --}}
            <x-card :padding="false">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 p-5">
                    <div class="flex items-center gap-3">
                        <x-avatar :name="$message->name" class="size-11 text-sm" />
                        <div>
                            <p class="font-semibold text-slate-900">{{ $message->name }}</p>
                            <div class="mt-0.5 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                                <a href="mailto:{{ $message->email }}" class="flex items-center gap-1 hover:text-brand-600">
                                    <x-icon name="envelope" class="size-3.5" /> {{ $message->email }}
                                </a>
                                @if ($message->phone)
                                    <a href="tel:{{ $message->phone }}" class="flex items-center gap-1 hover:text-brand-600">
                                        <x-icon name="phone" class="size-3.5" /> {{ $message->phone }}
                                    </a>
                                @endif
                                @if ($message->company)
                                    <span class="flex items-center gap-1">
                                        <x-icon name="building" class="size-3.5" /> {{ $message->company }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($message->service)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-600/20">
                            <x-icon :name="$message->service->icon" class="size-3.5" />
                            {{ $message->service->name }}
                        </span>
                    @endif
                </div>

                <div class="whitespace-pre-line p-5 text-sm leading-relaxed text-slate-700">{{ $message->message }}</div>
            </x-card>

            {{-- Admin reply --}}
            @if ($reply)
                <div class="ml-0 rounded-xl bg-white shadow-sm ring-1 ring-brand-600/20 sm:ml-10">
                    <div class="flex flex-wrap items-center justify-between gap-2 rounded-t-xl border-b border-brand-100 bg-brand-50/50 px-5 py-2.5">
                        <p class="flex items-center gap-2 text-xs font-medium text-brand-800">
                            <x-icon name="send" class="size-3.5" />
                            Reply sent by {{ $reply->user?->name ?? 'a removed user' }} to {{ $message->email }}
                        </p>
                        <span class="text-xs text-slate-400" title="{{ $reply->created_at->format('M j, Y g:i A') }}">
                            {{ $reply->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-medium text-slate-400">{{ $reply->subject }}</p>
                        <div class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $reply->body }}</div>
                    </div>
                </div>
            @endif

            {{-- Reply composer — a message can be replied to once --}}
            @if (! $reply)
                <x-card title="Reply by email">
                    <form method="POST" action="{{ route('admin.messages.reply', $message) }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-form.label for="reply-subject">Subject</x-form.label>
                            <x-form.input id="reply-subject" name="subject"
                                :value="old('subject', str($message->subject)->startsWith('Re:') ? $message->subject : 'Re: '.$message->subject)"
                                required class="mt-1.5" />
                            <x-form.error field="subject" />
                        </div>

                        <div>
                            <x-form.label for="reply-body">Message</x-form.label>
                            <x-form.textarea id="reply-body" name="body" rows="6" required class="mt-1.5"
                                placeholder="Write your reply to {{ $message->name }}…">{{ old('body') }}</x-form.textarea>
                            <x-form.error field="body" />
                            <p class="mt-1.5 text-xs text-slate-400">
                                Sent from the site's email with your configured signature. The reply is logged on this message.
                            </p>
                        </div>

                        <div class="flex justify-end">
                            <x-button type="submit" variant="primary" icon="send">Send reply</x-button>
                        </div>
                    </form>
                </x-card>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Triage controls: one-click pill selectors, no dropdowns --}}
            <x-card title="Tracking">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Status</p>
                        <form method="POST" action="{{ route('admin.messages.status', $message) }}"
                            class="mt-2 flex flex-wrap gap-1.5">
                            @csrf @method('PATCH')
                            @foreach ($statuses as $status)
                                <button type="submit" name="status" value="{{ $status->value }}"
                                    aria-pressed="{{ $message->status === $status ? 'true' : 'false' }}"
                                    @disabled($message->status === $status) @class([
                                    'rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset transition-colors',
                                    $status->badgeClasses() => $message->status === $status,
                                    'bg-white text-slate-500 ring-slate-200 hover:text-slate-700 hover:ring-slate-300' => $message->status !== $status,
                                ])>{{ $status->label() }}</button>
                            @endforeach
                        </form>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Priority</p>
                        <form method="POST" action="{{ route('admin.messages.priority', $message) }}"
                            class="mt-2 flex flex-wrap gap-1.5">
                            @csrf @method('PATCH')
                            @foreach ($priorities as $priority)
                                <button type="submit" name="priority" value="{{ $priority->value }}"
                                    aria-pressed="{{ $message->priority === $priority ? 'true' : 'false' }}"
                                    @disabled($message->priority === $priority) @class([
                                    'rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset transition-colors',
                                    $priority->badgeClasses() => $message->priority === $priority,
                                    'bg-white text-slate-500 ring-slate-200 hover:text-slate-700 hover:ring-slate-300' => $message->priority !== $priority,
                                ])>{{ $priority->label() }}</button>
                            @endforeach
                        </form>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Assigned to</p>
                        <form method="POST" action="{{ route('admin.messages.assign', $message) }}"
                            class="mt-2 flex flex-wrap gap-1.5">
                            @csrf @method('PATCH')
                            <button type="submit" name="assigned_to_id" value=""
                                aria-pressed="{{ $message->assigned_to_id === null ? 'true' : 'false' }}"
                                @disabled($message->assigned_to_id === null) @class([
                                'rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset transition-colors',
                                'bg-slate-100 text-slate-600 ring-slate-500/20' => $message->assigned_to_id === null,
                                'bg-white text-slate-500 ring-slate-200 hover:text-slate-700 hover:ring-slate-300' => $message->assigned_to_id !== null,
                            ])>Unassigned</button>
                            @foreach ($users as $user)
                                <button type="submit" name="assigned_to_id" value="{{ $user->id }}"
                                    aria-pressed="{{ $message->assigned_to_id === $user->id ? 'true' : 'false' }}"
                                    @disabled($message->assigned_to_id === $user->id) @class([
                                    'rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset transition-colors',
                                    'bg-brand-50 text-brand-700 ring-brand-600/20' => $message->assigned_to_id === $user->id,
                                    'bg-white text-slate-500 ring-slate-200 hover:text-slate-700 hover:ring-slate-300' => $message->assigned_to_id !== $user->id,
                                ])>{{ $user->name }}</button>
                            @endforeach
                        </form>
                    </div>
                </div>

                <dl class="mt-5 space-y-3 border-t border-slate-100 pt-4 text-xs">
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-slate-400">Received</dt>
                        <dd class="text-right font-medium text-slate-600">
                            {{ $message->created_at->format('M j, Y') }}
                            <span class="text-slate-400">{{ $message->created_at->format('g:i A') }}</span>
                        </dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-slate-400">First opened</dt>
                        <dd class="text-right font-medium text-slate-600">
                            @if ($message->read_at)
                                {{ $message->read_at->format('M j, Y') }}
                                <span class="text-slate-400">{{ $message->read_at->format('g:i A') }}</span>
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-slate-400">Replied</dt>
                        <dd class="text-right font-medium text-slate-600">
                            @if ($message->replied_at)
                                {{ $message->replied_at->format('M j, Y') }}
                                <span class="text-slate-400">{{ $message->replied_at->format('g:i A') }}</span>
                            @else
                                Not yet
                            @endif
                        </dd>
                    </div>
                    @if ($message->replied_at)
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-slate-400">Response time</dt>
                            <dd class="text-right font-medium text-emerald-600">
                                {{ $message->created_at->diffForHumans($message->replied_at, ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
                            </dd>
                        </div>
                    @endif
                    @if ($message->closed_at)
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-slate-400">Closed</dt>
                            <dd class="text-right font-medium text-slate-600">
                                {{ $message->closed_at->format('M j, Y') }}
                                <span class="text-slate-400">{{ $message->closed_at->format('g:i A') }}</span>
                            </dd>
                        </div>
                    @endif
                </dl>
            </x-card>

            {{-- Sender history --}}
            <x-card :title="'History with '.str($message->name)->before(' ')" :padding="false">
                @if ($previousMessages->isEmpty())
                    <div class="px-5 py-6 text-sm text-slate-500">
                        This is the first message from {{ $message->email }}.
                    </div>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach ($previousMessages as $previous)
                            <li>
                                <a href="{{ route('admin.messages.show', $previous) }}"
                                    class="flex items-center justify-between gap-3 px-5 py-3 transition-colors hover:bg-slate-50">
                                    <span class="min-w-0">
                                        <span class="block truncate text-sm font-medium text-slate-700">{{ $previous->subject }}</span>
                                        <span class="text-xs text-slate-400">{{ $previous->created_at->format('M j, Y') }}</span>
                                    </span>
                                    <x-status-badge :status="$previous->status" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-card>

            {{-- Activity timeline --}}
            <x-card title="Activity" :padding="false">
                <ol class="px-5 py-4">
                    @foreach ($message->activities as $activity)
                        <li class="relative flex gap-3 pb-4">
                            {{-- Connector line: the "received" entry below always follows. --}}
                            <span class="absolute left-[5px] top-4 h-full w-px bg-slate-200" aria-hidden="true"></span>
                            <span class="relative mt-1.5 size-[11px] shrink-0 rounded-full ring-2 ring-white {{ $activity->type->dotClasses() }}"></span>
                            <div class="min-w-0 text-sm">
                                <p class="text-slate-700">
                                    <span class="font-medium">{{ $activity->user?->name ?? 'System' }}</span>
                                    — {{ $activity->type->label() }}
                                    @if ($activity->type === \App\Enums\ContactActivityType::StatusChanged && $activity->meta)
                                        <span class="text-slate-500">
                                            ({{ \App\Enums\ContactMessageStatus::from($activity->meta['from'])->label() }}
                                            → {{ \App\Enums\ContactMessageStatus::from($activity->meta['to'])->label() }})
                                        </span>
                                    @elseif ($activity->type === \App\Enums\ContactActivityType::PriorityChanged && $activity->meta)
                                        <span class="text-slate-500">
                                            ({{ \App\Enums\ContactMessagePriority::from($activity->meta['from'])->label() }}
                                            → {{ \App\Enums\ContactMessagePriority::from($activity->meta['to'])->label() }})
                                        </span>
                                    @elseif ($activity->type === \App\Enums\ContactActivityType::Assigned)
                                        <span class="text-slate-500">({{ $activity->meta['to'] ?? 'Unassigned' }})</span>
                                    @endif
                                </p>
                                <p class="text-xs text-slate-400" title="{{ $activity->created_at->format('M j, Y g:i A') }}">
                                    {{ $activity->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </li>
                    @endforeach

                    {{-- The first event is always the message itself. --}}
                    <li class="relative flex gap-3">
                        <span class="relative mt-1.5 size-[11px] shrink-0 rounded-full bg-brand-600 ring-2 ring-white"></span>
                        <div class="text-sm">
                            <p class="text-slate-700"><span class="font-medium">{{ $message->name }}</span> — Message received</p>
                            <p class="text-xs text-slate-400">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                    </li>
                </ol>
            </x-card>
        </div>
    </div>

    {{-- Delete confirmation --}}
    <dialog id="delete-message"
        class="m-auto w-full max-w-md rounded-xl p-0 shadow-xl backdrop:bg-navy-950/50 backdrop:backdrop-blur-sm open:animate-in">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <h2 class="text-base font-semibold text-slate-900">Delete this message?</h2>
                <button type="button" data-modal-close
                    class="rounded-md p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Close">
                    <x-icon name="x" class="size-4" />
                </button>
            </div>

            <p class="mt-3 text-sm text-slate-600">
                This permanently deletes <span class="font-medium">{{ $message->reference }}</span> from
                {{ $message->name }}, including its replies, notes, and activity history. This cannot be undone.
            </p>

            <div class="mt-6 flex justify-end gap-2">
                <x-button variant="secondary" data-modal-close>Cancel</x-button>
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}">
                    @csrf @method('DELETE')
                    <x-button type="submit" variant="danger" icon="trash">Delete permanently</x-button>
                </form>
            </div>
        </div>
    </dialog>
@endsection
