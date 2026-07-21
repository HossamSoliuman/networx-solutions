@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
    <x-admin.page-header title="Messages"
        subtitle="Every enquiry sent through the contact form — track, assign, and reply.">
        <x-button :href="route('admin.messages.export', request()->query())" variant="secondary" icon="download">
            Export CSV
        </x-button>
    </x-admin.page-header>

    @php
        $view = $filters['view'] ?? 'inbox';
        $activeStatus = $filters['status'] ?? '';
    @endphp

    {{-- Inbox / Starred / Archived switcher --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="inline-flex rounded-lg bg-slate-200/70 p-1">
            @foreach (['inbox' => 'Inbox', 'starred' => 'Starred', 'archived' => 'Archived'] as $key => $label)
                <a href="{{ request()->fullUrlWithQuery(['view' => $key, 'status' => null, 'page' => null]) }}" @class([
                    'rounded-md px-3.5 py-1.5 text-sm font-medium transition-colors',
                    'bg-white text-navy-900 shadow-sm' => $view === $key,
                    'text-slate-600 hover:text-slate-900' => $view !== $key,
                ])>{{ $label }}</a>
            @endforeach
        </div>

        {{-- Status tabs --}}
        <nav class="flex flex-wrap gap-1.5">
            @foreach ([['', 'All'], ...collect($statuses)->map(fn ($s) => [$s->value, $s->label()])] as [$value, $label])
                @php $count = $statusCounts[$value === '' ? 'all' : $value] ?? 0; @endphp
                <a href="{{ request()->fullUrlWithQuery(['status' => $value ?: null, 'page' => null]) }}" @class([
                    'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-sm font-medium ring-1 ring-inset transition-colors',
                    'bg-brand-600 text-white ring-brand-600' => $activeStatus === $value,
                    'bg-white text-slate-600 ring-slate-200 hover:ring-slate-300' => $activeStatus !== $value,
                ])>
                    {{ $label }}
                    <span @class([
                        'text-xs',
                        'text-brand-200' => $activeStatus === $value,
                        'text-slate-400' => $activeStatus !== $value,
                    ])>{{ $count }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    {{-- Filters --}}
    <x-card :padding="false">
        {{-- Selects sit in fixed-width wrappers: the select component is w-full,
             so a width utility on the select itself loses the CSS conflict and
             every control stretched onto its own line. --}}
        <form method="GET" action="{{ route('admin.messages.index') }}" class="flex flex-wrap items-center gap-3 p-4">
            <input type="hidden" name="view" value="{{ $view }}">
            @if ($activeStatus)<input type="hidden" name="status" value="{{ $activeStatus }}">@endif

            <div class="relative min-w-52 flex-1 basis-60">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-2.5 size-4 text-slate-400" />
                <x-form.input name="q" :value="$filters['q'] ?? ''" placeholder="Search name, email, subject, reference…" class="pl-9" />
            </div>

            <div class="w-36 shrink-0">
                <x-form.select name="priority" data-autosubmit aria-label="Filter by priority">
                    <option value="">All priorities</option>
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority->value }}" @selected(($filters['priority'] ?? '') === $priority->value)>
                            {{ $priority->label() }}
                        </option>
                    @endforeach
                </x-form.select>
            </div>

            <div class="w-40 shrink-0">
                <x-form.select name="service_id" data-autosubmit aria-label="Filter by service">
                    <option value="">All services</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected(($filters['service_id'] ?? '') == $service->id)>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </x-form.select>
            </div>

            <div class="w-36 shrink-0">
                <x-form.select name="assigned" data-autosubmit aria-label="Filter by assignee">
                    <option value="">Anyone</option>
                    <option value="me" @selected(($filters['assigned'] ?? '') === 'me')>Assigned to me</option>
                    <option value="unassigned" @selected(($filters['assigned'] ?? '') === 'unassigned')>Unassigned</option>
                </x-form.select>
            </div>

            <div class="w-36 shrink-0">
                <x-form.select name="sort" data-autosubmit aria-label="Sort order">
                    <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Newest first</option>
                    <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Oldest first</option>
                    <option value="priority" @selected(($filters['sort'] ?? '') === 'priority')>By priority</option>
                </x-form.select>
            </div>

            <x-button type="submit" variant="secondary" icon="funnel">Filter</x-button>

            @if (array_filter($filters))
                <x-button :href="route('admin.messages.index')" variant="ghost">Clear</x-button>
            @endif
        </form>
    </x-card>

    {{-- Bulk actions --}}
    <form method="POST" action="{{ route('admin.messages.bulk') }}" data-bulk-form>
        @csrf
        <input type="hidden" name="action" data-bulk-action-input>
    </form>

    <x-card :padding="false">
        <div data-bulk-bar class="hidden flex-wrap items-center gap-2 border-b border-slate-100 bg-brand-50/60 px-4 py-2.5">
            <p class="mr-2 text-sm text-slate-600"><span class="font-semibold" data-bulk-count>0</span> selected</p>
            <x-button size="sm" variant="secondary" data-bulk-action="mark_read">Mark read</x-button>
            <x-button size="sm" variant="secondary" data-bulk-action="mark_unread">Mark unread</x-button>
            @if ($view === 'archived')
                <x-button size="sm" variant="secondary" data-bulk-action="restore" icon="reply">Restore</x-button>
            @else
                <x-button size="sm" variant="secondary" data-bulk-action="archive" icon="archive">Archive</x-button>
            @endif
            <x-button size="sm" variant="secondary" data-bulk-action="close" icon="check">Close</x-button>
            <x-button size="sm" variant="danger-soft" data-bulk-action="delete" icon="trash">Delete</x-button>
        </div>

        @if ($messages->isEmpty())
            <x-empty-state title="No messages found">
                @if (array_filter($filters))
                    Try adjusting or clearing the filters above.
                @else
                    New enquiries from the website contact form will land here.
                @endif
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                            <th class="w-10 px-4 py-3">
                                <input type="checkbox" data-bulk-all aria-label="Select all"
                                    class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600">
                            </th>
                            <th class="w-8 px-2 py-3"><span class="sr-only">Starred</span></th>
                            <th class="px-3 py-3">Sender</th>
                            <th class="px-3 py-3">Subject</th>
                            <th class="hidden px-3 py-3 lg:table-cell">Service</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="hidden px-3 py-3 xl:table-cell">Priority</th>
                            <th class="hidden px-3 py-3 xl:table-cell">Assigned</th>
                            <th class="px-3 py-3 text-right">Received</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($messages as $message)
                            <tr @class(['transition-colors hover:bg-slate-50', 'bg-brand-50/40' => $message->isUnread()])>
                                <td class="px-4 py-3">
                                    <input type="checkbox" value="{{ $message->id }}" data-bulk-item
                                        aria-label="Select message from {{ $message->name }}"
                                        class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600">
                                </td>
                                <td class="px-2 py-3">
                                    <form method="POST" action="{{ route('admin.messages.star', $message) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" aria-label="{{ $message->is_starred ? 'Unstar' : 'Star' }}"
                                            class="{{ $message->is_starred ? 'text-amber-400 hover:text-amber-500' : 'text-slate-300 hover:text-amber-400' }}">
                                            <x-icon name="star" :solid="$message->is_starred" class="size-4" />
                                        </button>
                                    </form>
                                </td>
                                <td class="max-w-44 px-3 py-3">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center gap-2.5">
                                        <x-avatar :name="$message->name" />
                                        <span class="min-w-0">
                                            <span class="block truncate {{ $message->isUnread() ? 'font-semibold text-slate-900' : 'font-medium text-slate-700' }}">
                                                {{ $message->name }}
                                            </span>
                                            <span class="block truncate text-xs text-slate-400">{{ $message->email }}</span>
                                        </span>
                                    </a>
                                </td>
                                <td class="max-w-64 px-3 py-3">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="block">
                                        <span class="block truncate {{ $message->isUnread() ? 'font-semibold text-slate-900' : 'text-slate-700' }}">
                                            {{ $message->subject }}
                                        </span>
                                        <span class="block text-xs text-slate-400">
                                            {{ $message->reference }}
                                            @if ($message->replies_count)
                                                · {{ $message->replies_count }} {{ str('reply')->plural($message->replies_count) }}
                                            @endif
                                        </span>
                                    </a>
                                </td>
                                <td class="hidden px-3 py-3 text-slate-500 lg:table-cell">
                                    {{ $message->service?->name ?? '—' }}
                                </td>
                                <td class="px-3 py-3"><x-status-badge :status="$message->status" /></td>
                                <td class="hidden px-3 py-3 xl:table-cell"><x-priority-badge :priority="$message->priority" /></td>
                                <td class="hidden px-3 py-3 xl:table-cell">
                                    @if ($message->assignedTo)
                                        <span class="flex items-center gap-1.5 text-slate-600">
                                            <x-avatar :name="$message->assignedTo->name" class="size-6 text-[0.6rem]" />
                                            <span class="truncate text-xs">{{ $message->assignedTo->name }}</span>
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-right text-xs text-slate-400"
                                    title="{{ $message->created_at->format('M j, Y g:i A') }}">
                                    {{ $message->created_at->diffForHumans(short: true) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-100 px-4 py-3">
                {{ $messages->links() }}
            </div>
        @endif
    </x-card>
@endsection
