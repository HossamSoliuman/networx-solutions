@extends('layouts.admin')

@section('title', $service->name.' plans')

@php
    use App\Enums\BillingPeriod;
@endphp

@section('content')
    <x-admin.page-header :title="$service->name.' — pricing plans'"
        subtitle="The plan cards shown in the pricing section of this service page.">
        <x-button :href="route('admin.services.edit', $service)" variant="secondary" icon="cog">Pricing section text</x-button>
        <x-button :href="route('admin.services.plans.create', $service)" variant="primary" icon="plus">Add plan</x-button>
    </x-admin.page-header>

    @unless ($service->pricing_enabled)
        <div class="flex items-center gap-2 rounded-lg bg-amber-50 px-4 py-2.5 text-sm text-amber-800 ring-1 ring-inset ring-amber-200">
            <x-icon name="warning" class="size-4" />
            The pricing section is switched off for this service, so these plans are not shown on the website.
            <a href="{{ route('admin.services.edit', $service) }}" class="font-semibold underline">Turn it on</a>
        </div>
    @endunless

    <x-card :padding="false">
        @if ($plans->isEmpty())
            <x-empty-state icon="currency" title="No plans yet">
                Add your first plan to show a pricing section on the {{ $service->name }} page.
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                            <th class="px-5 py-3">Plan</th>
                            <th class="px-3 py-3">Monthly</th>
                            <th class="hidden px-3 py-3 md:table-cell">Yearly</th>
                            <th class="hidden px-3 py-3 lg:table-cell">Features</th>
                            <th class="px-3 py-3">Requests</th>
                            <th class="px-3 py-3">Order</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($plans as $plan)
                            <tr class="transition-colors hover:bg-slate-50">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <span class="flex size-11 shrink-0 items-center justify-center rounded-lg ring-1 ring-inset ring-slate-200"
                                            style="color: {{ $plan->accent_color }}; background-color: {{ $plan->accent_color }}14;">
                                            <x-icon :name="$plan->icon" class="size-5" />
                                        </span>
                                        <div>
                                            <p class="flex items-center gap-2 font-medium text-slate-900">
                                                {{ $plan->name }}
                                                @if ($plan->is_featured)
                                                    <span class="rounded-full bg-navy-950 px-2 py-0.5 text-[0.6rem] font-bold uppercase tracking-wide text-white">
                                                        Featured
                                                    </span>
                                                @endif
                                            </p>
                                            <p class="text-xs text-slate-400">{{ $plan->capacity ?: '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3.5 text-slate-600">
                                    @if ($plan->is_custom_price)
                                        <span class="text-slate-400">{{ $plan->custom_price_label ?: 'Custom' }}</span>
                                    @else
                                        {{ $plan->formattedPriceFor(BillingPeriod::Monthly) ? $plan->formattedPriceFor(BillingPeriod::Monthly).$plan->price_suffix.' '.$plan->currency : '—' }}
                                    @endif
                                </td>
                                <td class="hidden whitespace-nowrap px-3 py-3.5 text-slate-600 md:table-cell">
                                    {{ $plan->formattedPriceFor(BillingPeriod::Yearly) ? $plan->formattedPriceFor(BillingPeriod::Yearly).' '.$plan->currency : '—' }}
                                </td>
                                <td class="hidden px-3 py-3.5 text-slate-500 lg:table-cell">{{ count($plan->featureList()) }}</td>
                                <td class="px-3 py-3.5 text-slate-600">{{ $plan->plan_requests_count }}</td>
                                <td class="px-3 py-3.5 text-slate-600">{{ $plan->sort_order }}</td>
                                <td class="px-3 py-3.5">
                                    @if ($plan->is_active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Active</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500 ring-1 ring-inset ring-slate-500/20">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <form method="POST" action="{{ route('admin.services.plans.status', [$service, $plan]) }}">
                                            @csrf @method('PATCH')
                                            @if ($plan->is_active)
                                                <x-button type="submit" variant="ghost" size="sm" icon="x">Deactivate</x-button>
                                            @else
                                                <x-button type="submit" variant="ghost" size="sm" icon="check"
                                                    class="text-emerald-700 hover:bg-emerald-50">Activate</x-button>
                                            @endif
                                        </form>
                                        <x-button :href="route('admin.services.plans.edit', [$service, $plan])" variant="ghost" size="sm">Edit</x-button>
                                        <x-button variant="ghost" size="sm" class="text-red-600 hover:bg-red-50"
                                            data-modal-open="delete-plan-{{ $plan->id }}">Delete</x-button>
                                    </div>

                                    <dialog id="delete-plan-{{ $plan->id }}"
                                        class="m-auto w-full max-w-md rounded-xl p-0 shadow-xl backdrop:bg-navy-950/50 backdrop:backdrop-blur-sm open:animate-in">
                                        <div class="p-6">
                                            <div class="flex items-start justify-between gap-4">
                                                <h2 class="text-base font-semibold text-slate-900">Delete “{{ $plan->name }}”?</h2>
                                                <button type="button" data-modal-close
                                                    class="rounded-md p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600"
                                                    aria-label="Close">
                                                    <x-icon name="x" class="size-4" />
                                                </button>
                                            </div>

                                            <p class="mt-3 text-sm text-slate-600">
                                                The card is removed from the website. Existing plan requests keep the plan
                                                name they were sent with. This cannot be undone.
                                            </p>

                                            <div class="mt-6 flex justify-end gap-2">
                                                <x-button variant="secondary" data-modal-close>Cancel</x-button>
                                                <form method="POST" action="{{ route('admin.services.plans.destroy', [$service, $plan]) }}">
                                                    @csrf @method('DELETE')
                                                    <x-button type="submit" variant="danger" icon="trash">Delete plan</x-button>
                                                </form>
                                            </div>
                                        </div>
                                    </dialog>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
@endsection
