@extends('layouts.admin')

@section('title', 'Plan requests')

@php
    use App\Enums\PlanRequestStatus;

    $activeStatus = $filters['status'] ?? '';
@endphp

@section('content')
    <x-admin.page-header title="Plan requests"
        subtitle="Visitors who picked a pricing plan and asked to be contacted." />

    <nav class="flex flex-wrap gap-1.5">
        @foreach ([['', 'All', $totalCount], ...collect(PlanRequestStatus::cases())->map(fn ($status) => [$status->value, $status->label(), $statusCounts[$status->value] ?? 0])] as [$value, $label, $count])
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

    <x-card :padding="false">
        <form method="GET" action="{{ route('admin.plan-requests.index') }}" class="flex flex-wrap items-center gap-3 p-4">
            @if ($activeStatus)<input type="hidden" name="status" value="{{ $activeStatus }}">@endif

            <div class="relative min-w-52 flex-1 basis-60">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-2.5 size-4 text-slate-400" />
                <x-form.input name="q" :value="$filters['q'] ?? ''" placeholder="Search name, phone, email, plan, reference…" class="pl-9" />
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
                <x-form.select name="sort" data-autosubmit aria-label="Sort order">
                    <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Newest first</option>
                    <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Oldest first</option>
                </x-form.select>
            </div>

            <x-button type="submit" variant="secondary" icon="funnel">Filter</x-button>

            @if (array_filter($filters))
                <x-button :href="route('admin.plan-requests.index')" variant="ghost">Clear</x-button>
            @endif
        </form>
    </x-card>

    <x-card :padding="false">
        @if ($planRequests->isEmpty())
            <x-empty-state icon="currency" title="No plan requests yet">
                @if (array_filter($filters))
                    Try adjusting or clearing the filters above.
                @else
                    When a visitor chooses a pricing plan on the website, their contact details land here.
                @endif
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                            <th class="px-5 py-3">Contact</th>
                            <th class="px-3 py-3">Plan</th>
                            <th class="hidden px-3 py-3 lg:table-cell">Service</th>
                            <th class="hidden px-3 py-3 xl:table-cell">Billing</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-3 py-3 text-right">Received</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($planRequests as $planRequest)
                            <tr @class(['transition-colors hover:bg-slate-50', 'bg-brand-50/40' => $planRequest->isUnread()])>
                                <td class="max-w-56 px-5 py-3">
                                    <a href="{{ route('admin.plan-requests.show', $planRequest) }}" class="flex items-center gap-2.5">
                                        <x-avatar :name="$planRequest->name ?: ($planRequest->email ?: '?')" />
                                        <span class="min-w-0">
                                            <span class="block truncate {{ $planRequest->isUnread() ? 'font-semibold text-slate-900' : 'font-medium text-slate-700' }}">
                                                {{ $planRequest->name ?: 'No name given' }}
                                            </span>
                                            <span class="block truncate text-xs text-slate-400" dir="ltr">
                                                {{ $planRequest->phone ?: $planRequest->email }}
                                            </span>
                                        </span>
                                    </a>
                                </td>
                                <td class="max-w-56 px-3 py-3">
                                    <a href="{{ route('admin.plan-requests.show', $planRequest) }}" class="block">
                                        <span class="block truncate {{ $planRequest->isUnread() ? 'font-semibold text-slate-900' : 'text-slate-700' }}">
                                            {{ $planRequest->plan_name }}
                                        </span>
                                        <span class="block text-xs text-slate-400">
                                            {{ $planRequest->reference }}
                                            @if ($planRequest->formattedPrice())
                                                · {{ $planRequest->formattedPrice() }}
                                            @endif
                                        </span>
                                    </a>
                                </td>
                                <td class="hidden px-3 py-3 text-slate-500 lg:table-cell">
                                    {{ $planRequest->service?->name ?? ($planRequest->service_name ?: '—') }}
                                </td>
                                <td class="hidden px-3 py-3 text-slate-500 xl:table-cell">
                                    {{ $planRequest->billing_period->label() }}
                                </td>
                                <td class="px-3 py-3"><x-status-badge :status="$planRequest->status" /></td>
                                <td class="whitespace-nowrap px-3 py-3 text-right text-xs text-slate-400"
                                    title="{{ $planRequest->created_at->format('M j, Y g:i A') }}">
                                    {{ $planRequest->created_at->diffForHumans(short: true) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-100 px-4 py-3">
                {{ $planRequests->links() }}
            </div>
        @endif
    </x-card>
@endsection
