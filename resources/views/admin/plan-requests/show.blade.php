@extends('layouts.admin')

@section('title', $planRequest->reference)

@php
    use App\Enums\PlanRequestStatus;
@endphp

@section('content')
    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <x-button :href="route('admin.plan-requests.index')" variant="ghost" icon="arrow-left">Plan requests</x-button>
            <div>
                <h1 class="flex items-center gap-2.5 font-display text-xl font-bold tracking-tight text-navy-900">
                    {{ $planRequest->plan_name }}
                    <x-status-badge :status="$planRequest->status" />
                </h1>
                <p class="mt-0.5 text-xs text-slate-400">
                    {{ $planRequest->reference }} · received {{ $planRequest->created_at->format('M j, Y \a\t g:i A') }}
                </p>
            </div>
        </div>

        <x-button variant="danger-soft" icon="trash" data-modal-open="delete-plan-request">Delete</x-button>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- Main column --}}
        <div class="space-y-6 xl:col-span-2">
            <x-card :padding="false">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 p-5">
                    <div class="flex items-center gap-3">
                        <x-avatar :name="$planRequest->name ?: ($planRequest->email ?: '?')" class="size-11 text-sm" />
                        <div>
                            <p class="font-semibold text-slate-900">{{ $planRequest->name ?: 'No name given' }}</p>
                            <div class="mt-0.5 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                                @if ($planRequest->phone)
                                    <a href="tel:{{ $planRequest->phone }}" class="flex items-center gap-1 hover:text-brand-600" dir="ltr">
                                        <x-icon name="phone" class="size-3.5" /> {{ $planRequest->phone }}
                                    </a>
                                @endif
                                @if ($planRequest->email)
                                    <a href="mailto:{{ $planRequest->email }}" class="flex items-center gap-1 hover:text-brand-600">
                                        <x-icon name="envelope" class="size-3.5" /> {{ $planRequest->email }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($planRequest->service)
                        <a href="{{ route('admin.services.plans.index', $planRequest->service) }}"
                            class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-600/20 hover:bg-brand-100">
                            <x-icon :name="$planRequest->service->icon" class="size-3.5" />
                            {{ $planRequest->service->name }}
                        </a>
                    @endif
                </div>

                <dl class="grid grid-cols-1 gap-px bg-slate-100 sm:grid-cols-3">
                    <div class="bg-white p-5">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Plan</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">
                            {{ $planRequest->plan_name }}
                            @unless ($planRequest->plan)
                                <span class="ml-1 text-xs font-normal text-slate-400">(plan removed)</span>
                            @endunless
                        </dd>
                    </div>
                    <div class="bg-white p-5">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Billing period</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ $planRequest->billing_period->label() }}</dd>
                    </div>
                    <div class="bg-white p-5">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Quoted price</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900">{{ $planRequest->formattedPrice() ?? 'Custom' }}</dd>
                    </div>
                </dl>

                @if ($planRequest->note)
                    <div class="border-t border-slate-100 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">What they told us</p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $planRequest->note }}</p>
                    </div>
                @endif
            </x-card>

            <x-card title="Internal note">
                <form method="POST" action="{{ route('admin.plan-requests.update', $planRequest) }}" class="space-y-4">
                    @csrf @method('PUT')

                    <div>
                        <x-form.label for="admin_note" class="sr-only">Internal note</x-form.label>
                        <x-form.textarea id="admin_note" name="admin_note" rows="5"
                            placeholder="What was agreed on the call, when to follow up…">{{ old('admin_note', $planRequest->admin_note) }}</x-form.textarea>
                        <x-form.error field="admin_note" />
                    </div>

                    <div class="flex justify-end">
                        <x-button type="submit" variant="primary" icon="check">Save note</x-button>
                    </div>
                </form>
            </x-card>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <x-card title="Follow-up">
                <form method="POST" action="{{ route('admin.plan-requests.status', $planRequest) }}" class="space-y-2">
                    @csrf @method('PATCH')

                    @foreach (PlanRequestStatus::cases() as $status)
                        <button type="submit" name="status" value="{{ $status->value }}" @class([
                            'flex w-full items-center justify-between gap-2 rounded-lg px-3 py-2 text-sm font-medium ring-1 ring-inset transition-colors',
                            'bg-brand-600 text-white ring-brand-600' => $planRequest->status === $status,
                            'bg-white text-slate-600 ring-slate-200 hover:bg-slate-50' => $planRequest->status !== $status,
                        ])>
                            {{ $status->label() }}
                            @if ($planRequest->status === $status)
                                <x-icon name="check" class="size-4" />
                            @endif
                        </button>
                    @endforeach
                </form>
            </x-card>

            <x-card title="Details">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Received</dt>
                        <dd class="text-right text-slate-800">{{ $planRequest->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Contacted</dt>
                        <dd class="text-right text-slate-800">
                            {{ $planRequest->contacted_at?->format('M j, Y g:i A') ?? 'Not yet' }}
                        </dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">Language</dt>
                        <dd class="text-right uppercase text-slate-800">{{ $planRequest->locale ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-slate-500">IP address</dt>
                        <dd class="text-right text-slate-800" dir="ltr">{{ $planRequest->ip_address ?? '—' }}</dd>
                    </div>
                </dl>
            </x-card>

            <x-card title="Quick actions">
                <div class="space-y-2">
                    @if ($planRequest->phone)
                        <x-button :href="'tel:'.$planRequest->phone" variant="secondary" icon="phone" class="w-full">
                            Call {{ $planRequest->phone }}
                        </x-button>
                    @endif
                    @if ($planRequest->email)
                        <x-button :href="'mailto:'.$planRequest->email" variant="secondary" icon="envelope" class="w-full">
                            Email {{ $planRequest->email }}
                        </x-button>
                    @endif
                    @if ($planRequest->service)
                        <x-button :href="route('services.show', $planRequest->service)" variant="ghost" icon="external" class="w-full">
                            View the plans page
                        </x-button>
                    @endif
                </div>
            </x-card>
        </div>
    </div>

    <dialog id="delete-plan-request"
        class="m-auto w-full max-w-md rounded-xl p-0 shadow-xl backdrop:bg-navy-950/50 backdrop:backdrop-blur-sm open:animate-in">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <h2 class="text-base font-semibold text-slate-900">Delete {{ $planRequest->reference }}?</h2>
                <button type="button" data-modal-close
                    class="rounded-md p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Close">
                    <x-icon name="x" class="size-4" />
                </button>
            </div>

            <p class="mt-3 text-sm text-slate-600">
                The request and its internal note are removed permanently. This cannot be undone.
            </p>

            <div class="mt-6 flex justify-end gap-2">
                <x-button variant="secondary" data-modal-close>Cancel</x-button>
                <form method="POST" action="{{ route('admin.plan-requests.destroy', $planRequest) }}">
                    @csrf @method('DELETE')
                    <x-button type="submit" variant="danger" icon="trash">Delete request</x-button>
                </form>
            </div>
        </div>
    </dialog>
@endsection
